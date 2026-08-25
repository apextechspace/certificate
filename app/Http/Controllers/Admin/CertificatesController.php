<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificatesController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'issued'   => Certificate::where('status', 'issued')->count(),
            'pending'  => Certificate::where('status', 'pending')->count(),
            'revoked'  => Certificate::where('status', 'revoked')->count(),
            'total'    => Certificate::count(),
        ];

        $query = Certificate::with(['participant', 'course', 'program', 'downloads']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('certificate_number', 'like', "%{$search}%")
                  ->orWhere('recipient_name', 'like', "%{$search}%")
                  ->orWhere('course_name', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $certificates = $query->latest('issued_at')->paginate(25)->withQueryString();

        return view('admin.certificates', compact('stats', 'certificates'));
    }
}
