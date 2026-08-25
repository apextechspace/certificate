<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\Program;
use App\Models\Course;
use Illuminate\Http\Request;

class ParticipantsController extends Controller
{
    public function index(Request $request)
    {
        $query = Participant::with([
            'registrations.course',
            'registrations.program',
            'registrations.eligibilityResult',
            'registrations.certificate',
        ]);

        // Search
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by program
        if ($programId = $request->get('program_id')) {
            $query->whereHas('registrations', fn($q) => $q->where('program_id', $programId));
        }

        // Filter by course
        if ($courseId = $request->get('course_id')) {
            $query->whereHas('registrations', fn($q) => $q->where('course_id', $courseId));
        }

        // Filter by eligibility
        if ($eligibility = $request->get('eligibility')) {
            $isEligible = $eligibility === 'eligible';
            $query->whereHas('registrations.eligibilityResult', function ($q) use ($isEligible) {
                $q->where('eligible', $isEligible);
            });
        }

        $participants = $query->latest()->paginate(25)->withQueryString();

        $programs = Program::all();
        $courses  = Course::all();

        return view('admin.participants', compact('participants', 'programs', 'courses'));
    }

    public function show(Participant $participant)
    {
        $participant->load([
            'registrations.course',
            'registrations.program',
            'registrations.eligibilityResult',
            'registrations.certificate',
        ]);
        return view('admin.participants-show', compact('participant'));
    }

    public function downloadCertificate(Participant $participant, \App\Models\Certificate $certificate)
    {
        if ($certificate->participant_id !== $participant->id) {
            abort(403);
        }

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

        return response($imageData, 200, [
            'Content-Type'        => 'image/png',
            'Content-Disposition' => 'attachment; filename="' . $certificate->certificate_number . '.png"',
            'Cache-Control'       => 'no-store',
        ]);
    }

    public function resendEmail(Participant $participant, \App\Models\Certificate $certificate)
    {
        if ($certificate->participant_id !== $participant->id) {
            abort(403);
        }

        try {
            \Illuminate\Support\Facades\Mail::to($participant->email)->send(new \App\Mail\CertificateIssuedMail($certificate));
            return redirect()->back()->with('success', 'Email successfully resent to ' . $participant->email);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send certificate email: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to send email. Check logs.');
        }
    }
}
