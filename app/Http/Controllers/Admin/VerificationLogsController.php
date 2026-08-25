<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificateVerification;
use Illuminate\Http\Request;

class VerificationLogsController extends Controller
{
    public function index(Request $request)
    {
        $query = CertificateVerification::with('certificate.participant');

        if ($search = $request->get('search')) {
            $query->whereHas('certificate', function ($q) use ($search) {
                $q->where('certificate_number', 'like', "%{$search}%")
                  ->orWhere('recipient_name', 'like', "%{$search}%");
            })->orWhere('ip_address', 'like', "%{$search}%");
        }

        $verifications = $query->latest('verified_at')->paginate(25)->withQueryString();

        $stats = [
            'total_verifications'   => CertificateVerification::count(),
            'valid_verifications'   => CertificateVerification::where('status', 'Valid')->count(),
            'invalid_verifications' => CertificateVerification::where('status', 'Not Found')->count(),
            'revoked_checks'        => CertificateVerification::where('status', 'Revoked')->count(),
        ];

        // Avoid division by zero in UI
        if ($stats['total_verifications'] === 0) {
            $stats['total_verifications'] = 1; 
        }

        return view('admin.verification', compact('verifications', 'stats'));
    }
}
