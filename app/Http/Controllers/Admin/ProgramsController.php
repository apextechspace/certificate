<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramsController extends Controller
{
    public function index(Request $request)
    {
        $programs = Program::withCount(['courses', 'registrations', 'certificates'])->paginate(10);
        
        $stats = [
            'active_programs' => Program::where('status', 'active')->count(),
            'total_courses'   => \App\Models\Course::count(),
            'enrolled'        => \App\Models\Registration::count(),
            'certificates'    => \App\Models\Certificate::count(),
        ];

        return view('admin.programs', compact('programs', 'stats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,draft,archived',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
        Program::create($data);
        return redirect()->route('admin.programs')->with('success', 'Program created successfully.');
    }

    public function update(Request $request, Program $program)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,draft,archived',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
        $program->update($data);
        return redirect()->route('admin.programs')->with('success', 'Program updated successfully.');
    }

    public function destroy(Program $program)
    {
        $program->delete();
        return redirect()->route('admin.programs')->with('success', 'Program deleted successfully.');
    }
}
