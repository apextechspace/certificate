<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Participant;
use App\Models\CertificateDownload;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Homepage — certificate lookup landing page.
     */
    public function home()
    {
        $stats = [
            'participants'        => Participant::count(),
            'certificates_issued' => Certificate::where('status', 'issued')->count(),
        ];
        
        return view('public.home', compact('stats'));
    }

    /**
     * AJAX lookup by email — returns JSON with certificate info or error state.
     * POST /lookup
     */
    public function lookup(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $email = strtolower(trim($request->input('email')));

        // Find participant
        $participant = Participant::where('email', $email)->first();

        if (!$participant) {
            return response()->json(['state' => 'notfound']);
        }

        // Find all active certificates for this participant
        $certificates = \App\Models\Certificate::where('participant_id', $participant->id)
            ->where('status', 'issued')
            ->latest()
            ->get();

        if ($certificates->isEmpty()) {
            // Check if they have any eligibility results indicating ineligibility
            $anyReg = $participant->registrations()
                ->whereHas('eligibilityResult', fn($q) => $q->where('eligible', false))
                ->first();
            
            if ($anyReg) {
                return response()->json(['state' => 'ineligible']);
            }
            return response()->json(['state' => 'notfound']);
        }

        $certsData = [];
        foreach ($certificates as $cert) {
            $certsData[] = [
                'name'           => $cert->recipient_name,
                'course'         => $cert->course_name,
                'certificate_id' => $cert->certificate_number,
                'issue_date'     => $cert->issued_at?->format('F j, Y') ?? 'N/A',
                'type'           => 'Certificate of Completion',
                'cert_url'       => url('/certificate/' . $cert->certificate_number),
            ];
        }

        return response()->json([
            'state'        => 'found',
            'certificates' => $certsData,
        ]);
    }

    /**
     * Certificate preview page.
     * GET /certificate/{certNumber}
     */
    public function certificate(string $certNumber)
    {
        $certificate = Certificate::where('certificate_number', $certNumber)
            ->where('status', 'issued')
            ->first();

        if (!$certificate) {
            abort(404, 'Certificate not found.');
        }

        $cert = [
            'name'           => $certificate->recipient_name,
            'course'         => $certificate->course_name,
            'certificate_id' => $certificate->certificate_number,
            'issue_date'     => $certificate->issued_at?->format('F j, Y') ?? 'N/A',
            'type'           => 'Certificate of Completion',
            'verify_url'     => url('/verify/' . $certificate->certificate_number),
            'render_url'     => url('/api/certificate/' . $certificate->certificate_number . '/render'),
            'download_url'   => url('/certificate/' . $certificate->certificate_number . '/download'),
        ];

        return view('public.certificate', compact('cert'));
    }

    /**
     * Serve the rendered certificate as a PNG download and log it.
     * GET /certificate/{certNumber}/download
     */
    public function download(string $certNumber)
    {
        $certificate = Certificate::where('certificate_number', $certNumber)
            ->where('status', 'issued')
            ->firstOrFail();

        // Record the download
        CertificateDownload::create([
            'certificate_id'  => $certificate->id,
            'ip_address'      => request()->ip(),
            'user_agent'      => request()->userAgent(),
            'downloaded_at'   => now(),
            'download_method' => 'portal',
        ]);

        // Render the certificate image
        $renderer = new \App\Services\CertificateRenderer();
        $certData = [
            'name'           => $certificate->recipient_name,
            'course'         => $certificate->course_name,
            'certificate_id' => $certificate->certificate_number,
            'issue_date'     => $certificate->issued_at?->format('F j, Y') ?? 'N/A',
            'type'           => 'Certificate of Completion',
        ];

        $img = $renderer->render($certData);

        ob_start();
        imagepng($img);
        $imageData = ob_get_clean();
        imagedestroy($img);

        $filename = $certificate->certificate_number . '.png';

        return response($imageData, 200, [
            'Content-Type'        => 'image/png',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'no-store',
        ]);
    }

    /**
     * Public verification page.
     * GET /verify/{certNumber}
     */
    public function verify(string $certNumber)
    {
        $certificate = Certificate::where('certificate_number', $certNumber)
            ->with(['course', 'program'])
            ->first();

        if (!$certificate) {
            $state = 'notfound';
            $cert  = [
                'name'           => '',
                'course'         => '',
                'certificate_id' => $certNumber,
                'issue_date'     => '',
                'type'           => '',
                'verify_url'     => url('/verify/' . $certNumber),
            ];
            return view('public.verify', compact('cert', 'state'));
        }

        $state = match($certificate->status) {
            'revoked'  => 'revoked',
            'issued'   => 'valid',
            default    => 'notfound',
        };

        // Log the verification attempt
        \App\Models\CertificateVerification::create([
            'certificate_id' => $certificate->id,
            'ip_address'     => request()->ip(),
            'user_agent'     => request()->userAgent(),
            'source'         => request()->query('source', 'portal'),
            'status'         => $state === 'valid' ? 'Valid' : ($state === 'revoked' ? 'Revoked' : 'Not Found'),
            'verified_at'    => now(),
        ]);

        $cert = [
            'name'           => $certificate->recipient_name,
            'course'         => $certificate->course_name,
            'certificate_id' => $certificate->certificate_number,
            'issue_date'     => $certificate->issued_at?->format('F j, Y') ?? 'N/A',
            'type'           => 'Certificate of Completion',
            'verify_url'     => url('/verify/' . $certificate->certificate_number),
            'render_url'     => url('/api/certificate/' . $certificate->certificate_number . '/render'),
            'program'        => $certificate->program?->name ?? 'UmeraBoost 5.0',
        ];

        return view('public.verify', compact('cert', 'state'));
    }

    /**
     * Show the public attendance form.
     */
    public function showAttendanceForm()
    {
        $courses = \App\Models\Course::with('program')->where('status', 'active')->get();
        return view('public.attendance', compact('courses'));
    }

    /**
     * Mark participant attendance.
     */
    public function markAttendance(Request $request)
    {
        $request->validate([
            'email'                => ['required', 'email'],
            'course_id'            => ['required', 'exists:courses,id'],
            'timetable_session_id' => ['required', 'exists:timetable_sessions,id'],
        ]);

        $email = strtolower(trim($request->input('email')));
        $participant = Participant::where('email', $email)->first();

        if (!$participant) {
            return redirect()->back()->withErrors(['email' => 'We couldn\'t find a registration using that email address.']);
        }

        $registration = $participant->registrations()
            ->where('course_id', $request->input('course_id'))
            ->first();

        if (!$registration) {
            return redirect()->back()->withErrors(['email' => 'You are not registered for the selected course.']);
        }

        // Verify timetable session belongs to the course
        $session = \App\Models\TimetableSession::where('id', $request->input('timetable_session_id'))
            ->where('course_id', $request->input('course_id'))
            ->first();

        if (!$session) {
            return redirect()->back()->withErrors(['timetable_session_id' => 'Invalid timetable session selected.']);
        }

        // Check if attendance already marked
        $exists = \App\Models\Attendance::where('registration_id', $registration->id)
            ->where('timetable_session_id', $session->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Attendance has already been marked for this session.');
        }

        // Mark attendance
        \App\Models\Attendance::create([
            'participant_id'       => $participant->id,
            'registration_id'      => $registration->id,
            'timetable_session_id' => $session->id,
            'marked_at'            => now(),
            'ip_address'           => $request->ip(),
        ]);

        // Recalculate attendance status
        $totalSessions = \App\Models\TimetableSession::where('course_id', $request->input('course_id'))->count();
        $attendedCount = \App\Models\Attendance::where('registration_id', $registration->id)->count();

        // 75% attendance requirement (e.g. 3 out of 4 sessions)
        $requiredAttendance = max(1, ceil($totalSessions * 0.75));
        $isAttendanceSufficient = $attendedCount >= $requiredAttendance;

        $result = \App\Models\EligibilityResult::updateOrCreate(
            [
                'registration_id' => $registration->id,
            ],
            [
                'participant_id'    => $participant->id,
                'program_id'        => $registration->program_id,
                'course_id'         => $registration->course_id,
                'attendance_status' => $isAttendanceSufficient ? 'Present' : 'Absent',
                'evaluated_at'      => now(),
            ]
        );

        // Auto evaluate eligibility (attendance Present & assessment Passed & completion Completed)
        if (!$result->manual_override) {
            $isEligible = ($result->attendance_status === 'Present') && 
                          ($result->assessment_status === 'Passed') && 
                          ($result->completion_status === 'Completed');

            $result->update([
                'eligible' => $isEligible,
            ]);

            // If eligible, automatically issue certificate if not already present
            if ($isEligible) {
                $course = $registration->course;
                $certNo = 'UMB5-' . strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $course->name), 0, 3)) . '-' . date('Y') . '-' . str_pad($registration->id, 5, '0', STR_PAD_LEFT);
                $uuid = \Illuminate\Support\Str::uuid();
                
                \App\Models\Certificate::firstOrCreate(
                    ['registration_id' => $registration->id],
                    [
                        'certificate_number' => $certNo,
                        'certificate_uuid'   => $uuid,
                        'participant_id'     => $participant->id,
                        'program_id'         => $registration->program_id,
                        'course_id'          => $registration->course_id,
                        'course_name'        => $course->name,
                        'recipient_name'     => $participant->name,
                        'status'             => 'issued',
                        'issued_at'          => now(),
                        'verification_hash'  => hash('sha256', $uuid . $certNo . 'umera-salt'),
                        'generated_at'       => now(),
                    ]
                );
            }
        }

        return redirect()->back()->with('success', 'Attendance marked successfully! (' . $attendedCount . '/' . $totalSessions . ' sessions attended)');
    }
}
