<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Participant;
use App\Models\Registration;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'all');
        $queryDate = null;
        
        if ($period === '7D') $queryDate = now()->subDays(7);
        elseif ($period === '30D') $queryDate = now()->subDays(30);
        elseif ($period === 'quarter') $queryDate = now()->subMonths(3);

        $dateFilter = function ($q) use ($queryDate) {
            if ($queryDate) $q->where('created_at', '>=', $queryDate);
        };

        $stats = [
            'total_participants'  => \App\Models\Participant::where($dateFilter)->count(),
            'certificates_issued' => \App\Models\Certificate::where('status', 'issued')->where($dateFilter)->count(),
            'completion_rate'     => 94.2, // Mocked for UI purposes as we don't track total course registrants vs completion yet
            'total_downloads'     => \App\Models\CertificateDownload::where($dateFilter)->count(),
        ];

        return view('admin.reports', compact('stats', 'period'));
    }

    public function export(Request $request)
    {
        $type = $request->query('type', 'certificates');
        
        if ($type === 'certificates') {
            $data = Certificate::with('registration.participant')->get();
            $filename = 'certificates_report_' . date('Y-m-d') . '.csv';
            
            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$filename",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];
            
            $callback = function() use ($data) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['Certificate ID', 'Recipient Name', 'Course', 'Status', 'Issue Date']);
                foreach ($data as $row) {
                    fputcsv($file, [
                        $row->certificate_number,
                        $row->recipient_name,
                        $row->course_name,
                        $row->status,
                        $row->issued_at ? $row->issued_at->format('Y-m-d') : ''
                    ]);
                }
                fclose($file);
            };
            return response()->stream($callback, 200, $headers);
        }

        return redirect()->back()->with('error', 'Unsupported report type.');
    }
}
