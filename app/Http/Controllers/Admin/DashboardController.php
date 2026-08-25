<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Participant;
use App\Models\Registration;
use App\Models\EligibilityResult;
use App\Models\CertificateDownload;
use App\Models\AdminActivityLog;
use App\Models\Program;
use App\Models\Course;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'participants'         => Participant::count(),
            'eligible'             => EligibilityResult::where('eligible', true)->count(),
            'certificates_issued'  => Certificate::where('status', 'issued')->count(),
            'downloaded'           => CertificateDownload::distinct('certificate_id')->count('certificate_id'),
            'not_downloaded'       => Certificate::where('status', 'issued')
                                        ->doesntHave('downloads')
                                        ->count(),
            'revoked'              => Certificate::where('status', 'revoked')->count(),
            'programs'             => Program::count(),
            'courses'              => Course::count(),
            'total_verifications'  => 0,
        ];

        $recentCertificates = Certificate::with(['participant', 'course'])
            ->where('status', 'issued')
            ->latest()
            ->take(5)
            ->get();

        $recentActivity = AdminActivityLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        $programs = Program::withCount(['courses', 'registrations'])->get();

        return view('admin.dashboard', compact('stats', 'recentCertificates', 'recentActivity', 'programs'));
    }
}
