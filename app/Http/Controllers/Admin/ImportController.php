<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\Program;
use App\Services\ImportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImportController extends Controller
{
    public function __construct(private ImportService $importService) {}

    /**
     * Show the import page with recent import logs.
     */
    public function index()
    {
        $programs = Program::all();
        $recentImports = AdminActivityLog::where('action', 'import')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.imports', compact('programs', 'recentImports'));
    }

    /**
     * Download a sample CSV template.
     */
    public function template()
    {
        $csv = "name,email,phone,course_slug\n";
        $csv .= "Adeyemo Goodness,goodness@example.com,08012345678,gai\n";
        $csv .= "Ali Umar,ali@example.com,08023456789,personal-finance\n";
        $csv .= "Muhammad Ibrahim,ibrahim@example.com,08034567890,advanced-bd\n";
        $csv .= "Abdulrahman Sani,sani@example.com,08045678901,digital-marketing\n";

        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="umera_import_template.csv"',
        ]);
    }

    /**
     * Handle file upload: parse + validate, return preview data via session.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file'       => ['required', 'file', 'mimes:csv,xlsx,xls', 'max:10240'],
            'program_id' => ['required', 'exists:programs,id'],
        ]);

        $file      = $request->file('file');
        $programId = (int) $request->input('program_id');

        $parsed   = $this->importService->parse($file);
        $validated = $this->importService->validate($parsed['rows'], $programId);

        // Store valid rows in session for confirmation step
        $sessionKey = 'import_' . now()->timestamp;
        session([
            'import_data' => [
                'key'        => $sessionKey,
                'program_id' => $programId,
                'filename'   => $file->getClientOriginalName(),
                'total'      => count($parsed['rows']),
                'valid'      => $validated['valid'],
                'duplicates' => $validated['duplicates'],
                'errored'    => $validated['errored'],
            ],
        ]);

        return redirect()->route('admin.imports.preview');
    }

    /**
     * Show preview of import results.
     */
    public function preview()
    {
        if (!session('import_data')) {
            return redirect()->route('admin.imports')->with('error', 'No import session found. Please upload a file.');
        }

        $importData = session('import_data');
        $programs   = Program::all();

        return view('admin.imports-preview', compact('importData', 'programs'));
    }

    /**
     * Confirm and execute the import of valid rows.
     */
    public function confirm(Request $request)
    {
        if (!session('import_data')) {
            return redirect()->route('admin.imports')->with('error', 'Import session expired. Please upload again.');
        }

        $importData = session('import_data');
        $created    = $this->importService->persist($importData['valid'], $importData['program_id']);

        // Log the import activity
        AdminActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'import',
            'description' => "Imported {$created} participants from '{$importData['filename']}'",
            'metadata'    => json_encode([
                'filename'   => $importData['filename'],
                'total'      => $importData['total'],
                'imported'   => $created,
                'duplicates' => count($importData['duplicates']),
                'errored'    => count($importData['errored']),
            ]),
        ]);

        session()->forget('import_data');

        return redirect()->route('admin.participants')
            ->with('success', "✅ Successfully imported {$created} participants.");
    }
}
