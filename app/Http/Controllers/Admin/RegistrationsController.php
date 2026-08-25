<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use Illuminate\Http\Request;

class RegistrationsController extends Controller
{
    public function index(Request $request)
    {
        $query = Participant::with(['program', 'course']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('participant_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $registrations = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => Participant::count(),
            'eligible' => Participant::where('eligibility_status', 'eligible')->count(),
            'not_eligible' => Participant::where('eligibility_status', 'not_eligible')->count(),
            'certificates_issued' => \App\Models\Certificate::where('status', 'issued')->count(),
        ];

        return view('admin.registrations', compact('registrations', 'stats'));
    }
}
