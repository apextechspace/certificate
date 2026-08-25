<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\EligibilityResult;
use Illuminate\Http\Request;

class EligibilityController extends Controller
{
    public function index(Request $request)
    {
        $query = Registration::with(['participant', 'course', 'eligibilityResult']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('participant', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('registration_reference', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $status = $request->status;
            $query->whereHas('eligibilityResult', function($q) use ($status) {
                 $q->where('eligible', $status === 'eligible');
            });
        }

        $registrations = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => Registration::count(),
            'eligible' => EligibilityResult::where('eligible', true)->count(),
            'not_eligible' => EligibilityResult::where('eligible', false)->count(),
            'pending' => Registration::doesntHave('eligibilityResult')->count(),
        ];

        return view('admin.eligibility', compact('registrations', 'stats'));
    }

    public function check(Request $request)
    {
        $registrations = Registration::with(['participant', 'course', 'eligibilityResult'])->get();
        
        $updated = 0;
        foreach ($registrations as $r) {
            $result = EligibilityResult::firstOrCreate(
                ['registration_id' => $r->id],
                [
                    'participant_id' => $r->participant_id,
                    'program_id'     => $r->program_id,
                    'course_id'      => $r->course_id,
                    'attendance_status' => 'Absent',
                    'assessment_status' => 'Pending',
                    'completion_status' => 'Pending',
                    'eligible'          => false,
                    'evaluated_at'      => now(),
                ]
            );

            if (!$result->manual_override) {
                // Calculate attendance sufficiency (75% check)
                $totalSessions = \App\Models\TimetableSession::where('course_id', $r->course_id)->count();
                $attendedCount = \App\Models\Attendance::where('registration_id', $r->id)->count();

                if ($totalSessions > 0) {
                    $requiredAttendance = max(1, ceil($totalSessions * 0.75));
                    $isAttendanceSufficient = $attendedCount >= $requiredAttendance;
                    $result->attendance_status = $isAttendanceSufficient ? 'Present' : 'Absent';
                }

                $isEligible = ($result->attendance_status === 'Present') &&
                              ($result->assessment_status === 'Passed') &&
                              ($result->completion_status === 'Completed');

                $result->eligible = $isEligible;
                $result->evaluated_at = now();
                $result->save();

                // Auto issue certificate if eligible
                if ($isEligible) {
                    $course = $r->course;
                    $certNo = 'UMB5-' . strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $course->name), 0, 3)) . '-' . date('Y') . '-' . str_pad($r->id, 5, '0', STR_PAD_LEFT);
                    $uuid = \Illuminate\Support\Str::uuid();

                    \App\Models\Certificate::firstOrCreate(
                        ['registration_id' => $r->id],
                        [
                            'certificate_number' => $certNo,
                            'certificate_uuid'   => $uuid,
                            'participant_id'     => $r->participant_id,
                            'program_id'         => $r->program_id,
                            'course_id'          => $r->course_id,
                            'course_name'        => $course->name,
                            'recipient_name'     => $r->participant->name,
                            'status'             => 'issued',
                            'issued_at'          => now(),
                            'verification_hash'  => hash('sha256', $uuid . $certNo . 'umera-salt'),
                            'generated_at'       => now(),
                        ]
                    );
                } else {
                    $certificate = \App\Models\Certificate::where('registration_id', $r->id)->first();
                    if ($certificate) {
                        $certificate->update(['status' => 'revoked']);
                    }
                }
            }
            $updated++;
        }

        return redirect()->route('admin.eligibility')->with('success', "✅ Re-evaluated eligibility for {$updated} registrations.");
    }

    public function update(Request $request, Registration $registration)
    {
        $data = $request->validate([
            'attendance_status' => 'required|string|in:Present,Absent',
            'assessment_status' => 'required|string|in:Passed,Failed,Pending',
            'completion_status' => 'required|string|in:Completed,Pending',
            'manual_override'   => 'nullable',
            'eligible'          => 'required|boolean',
            'reason'            => 'nullable|string',
        ]);

        $data['manual_override'] = $request->has('manual_override');
        $data['evaluated_at'] = now();
        $data['evaluated_by'] = auth()->id();

        $result = EligibilityResult::updateOrCreate(
            ['registration_id' => $registration->id],
            array_merge([
                'participant_id' => $registration->participant_id,
                'program_id'     => $registration->program_id,
                'course_id'      => $registration->course_id,
            ], $data)
        );

        if ($result->eligible) {
            $course = $registration->course;
            $certNo = 'UMB5-' . strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $course->name), 0, 3)) . '-' . date('Y') . '-' . str_pad($registration->id, 5, '0', STR_PAD_LEFT);
            $uuid = \Illuminate\Support\Str::uuid();

            \App\Models\Certificate::updateOrCreate(
                ['registration_id' => $registration->id],
                [
                    'certificate_number' => $certNo,
                    'certificate_uuid'   => $uuid,
                    'participant_id'     => $registration->participant_id,
                    'program_id'         => $registration->program_id,
                    'course_id'          => $registration->course_id,
                    'course_name'        => $course->name,
                    'recipient_name'     => $registration->participant->name,
                    'status'             => 'issued',
                    'issued_at'          => now(),
                    'verification_hash'  => hash('sha256', $uuid . $certNo . 'umera-salt'),
                    'generated_at'       => now(),
                ]
            );
        } else {
            $certificate = \App\Models\Certificate::where('registration_id', $registration->id)->first();
            if ($certificate) {
                $certificate->update(['status' => 'revoked']);
            }
        }

        return redirect()->route('admin.eligibility')->with('success', 'Participant eligibility updated successfully.');
    }
}
