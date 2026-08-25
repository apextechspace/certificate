<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function index()
    {
        $courses = Course::with('program')->withCount(['registrations', 'certificates'])->paginate(10);
        $programs = \App\Models\Program::all();
        
        $stats = [
            'total_courses'       => Course::count(),
            'active_courses'      => Course::where('status', 'active')->count(),
            'participants'        => \App\Models\Participant::count(),
            'certificates_issued' => \App\Models\Certificate::where('status', 'issued')->count(),
        ];
        
        return view('admin.courses', compact('courses', 'programs', 'stats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:courses',
            'duration' => 'nullable|string|max:255',
        ]);
        Course::create($data);
        return redirect()->route('admin.courses')->with('success', 'Course created successfully.');
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:courses,slug,' . $course->id,
            'duration' => 'nullable|string|max:255',
        ]);
        $course->update($data);
        return redirect()->route('admin.courses')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses')->with('success', 'Course deleted successfully.');
    }

    public function exportParticipants(Course $course)
    {
        $participants = \App\Models\Participant::whereHas('registrations', function ($query) use ($course) {
            $query->where('course_id', $course->id);
        })->get();

        $filename = 'course_' . $course->slug . '_participants_' . date('Y-m-d') . '.csv';
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
        
        $callback = function() use ($participants) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Name', 'Email', 'Phone', 'Created At']);
            foreach ($participants as $row) {
                fputcsv($file, [
                    $row->name,
                    $row->email,
                    $row->phone_number,
                    $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : ''
                ]);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
