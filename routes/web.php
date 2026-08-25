<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ParticipantsController;
use App\Http\Controllers\Admin\CertificatesController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\ProgramsController;
use App\Http\Controllers\Admin\CoursesController;
use App\Http\Controllers\Admin\EligibilityController;
use App\Http\Controllers\Admin\DownloadsController;
use App\Http\Controllers\Admin\VerificationLogsController;
use App\Http\Controllers\Admin\ActivityLogsController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\TemplatesController;
use App\Http\Controllers\Admin\SettingsController;

// ─── PUBLIC PORTAL ────────────────────────────────────────────────────────────
Route::get('/',                                  [PublicController::class, 'home']);
Route::post('/lookup',                           [PublicController::class, 'lookup'])->name('lookup');
Route::get('/certificate/{certNumber}/download', [PublicController::class, 'download'])->name('certificate.download');
Route::get('/certificate/{certNumber}',          [PublicController::class, 'certificate'])->name('certificate.view');
Route::get('/verify/{certNumber}',               [PublicController::class, 'verify'])->name('certificate.verify');
Route::get('/attendance',                        [PublicController::class, 'showAttendanceForm'])->name('attendance');
Route::post('/attendance',                       [PublicController::class, 'markAttendance'])->name('attendance.mark');

// ─── CERTIFICATE RENDERER API ─────────────────────────────────────────────────
Route::get('/api/certificate/{id}/render', function ($id) {
    $certificate = \App\Models\Certificate::where('certificate_number', $id)->first();

    $certData = $certificate ? [
        'name'           => $certificate->recipient_name,
        'course'         => $certificate->course_name,
        'certificate_id' => $certificate->certificate_number,
        'issue_date'     => $certificate->issued_at?->format('F j, Y') ?? 'N/A',
        'type'           => 'Certificate of Completion',
    ] : [
        // Fallback for testing with a raw ID that isn't in DB
        'name'           => 'Participant Name',
        'course'         => 'Course Name',
        'certificate_id' => $id,
        'issue_date'     => now()->format('F j, Y'),
        'type'           => 'Certificate of Completion',
    ];

    $renderer = new \App\Services\CertificateRenderer();
    $debug    = request()->has('debug');
    $img      = $renderer->render($certData, $debug);

    ob_start();
    imagepng($img);
    $imageData = ob_get_clean();
    imagedestroy($img);

    return response($imageData)
        ->header('Content-Type', 'image/png')
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->middleware(\App\Http\Middleware\AdminAccessMiddleware::class)
        ->name('admin.login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth')->group(function () {
        // Real data controllers
        Route::get('/dashboard',     [DashboardController::class,    'index'])->name('admin.dashboard');
        
        Route::get('/participants', [ParticipantsController::class, 'index'])->name('admin.participants');
        Route::get('/participants/{participant}', [ParticipantsController::class, 'show'])->name('admin.participants.show');
        Route::get('/participants/{participant}/certificate/{certificate}/download', [ParticipantsController::class, 'downloadCertificate'])->name('admin.participants.download');
        Route::post('/participants/{participant}/certificate/{certificate}/resend', [ParticipantsController::class, 'resendEmail'])->name('admin.participants.resend');

        Route::get('/certificates',  [CertificatesController::class, 'index'])->name('admin.certificates');

        // Import routes
        Route::get('/imports',               [ImportController::class, 'index'])  ->name('admin.imports');
        Route::get('/imports/template',      [ImportController::class, 'template'])->name('admin.imports.template');
        Route::post('/imports/upload',       [ImportController::class, 'upload'])  ->name('admin.imports.upload');
        Route::get('/imports/preview',       [ImportController::class, 'preview']) ->name('admin.imports.preview');
        Route::post('/imports/confirm',      [ImportController::class, 'confirm']) ->name('admin.imports.confirm');
        Route::get('/templates', [TemplatesController::class, 'index'])->name('admin.templates');

        Route::get('/downloads', [DownloadsController::class, 'index'])->name('admin.downloads');
        Route::get('/downloads/export', [DownloadsController::class, 'export'])->name('admin.downloads.export');
        
        Route::get('/verification', [VerificationLogsController::class, 'index'])->name('admin.verification');
        
        Route::get('/activity-logs', [ActivityLogsController::class, 'index'])->name('admin.activity-logs');
        Route::get('/activity-logs/export', [ActivityLogsController::class, 'export'])->name('admin.activity-logs.export');

        Route::get('/programs', [ProgramsController::class, 'index'])->name('admin.programs');
        Route::post('/programs', [ProgramsController::class, 'store'])->name('admin.programs.store');
        Route::put('/programs/{program}', [ProgramsController::class, 'update'])->name('admin.programs.update');
        Route::delete('/programs/{program}', [ProgramsController::class, 'destroy'])->name('admin.programs.destroy');

        Route::get('/courses',  [CoursesController::class, 'index'])->name('admin.courses');
        Route::post('/courses', [CoursesController::class, 'store'])->name('admin.courses.store');
        Route::put('/courses/{course}', [CoursesController::class, 'update'])->name('admin.courses.update');
        Route::delete('/courses/{course}', [CoursesController::class, 'destroy'])->name('admin.courses.destroy');
        Route::get('/courses/{course}/export', [CoursesController::class, 'exportParticipants'])->name('admin.courses.export');

        Route::get('/eligibility', [EligibilityController::class, 'index'])->name('admin.eligibility');
        Route::post('/eligibility/check', [EligibilityController::class, 'check'])->name('admin.eligibility.check');
        Route::put('/eligibility/{registration}', [EligibilityController::class, 'update'])->name('admin.eligibility.update');

        Route::get('/certificates', [CertificatesController::class, 'index'])->name('admin.certificates');
        Route::post('/certificates/{certificate}/revoke', [CertificatesController::class, 'revoke'])->name('admin.certificates.revoke');

        Route::get('/reports', [ReportsController::class, 'index'])->name('admin.reports');
        Route::get('/reports/export', [ReportsController::class, 'export'])->name('admin.reports.export');

        Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings');
        Route::post('/settings', [SettingsController::class, 'update'])->name('admin.settings.update');
    });
});
