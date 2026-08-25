<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificateDownload;
use Illuminate\Http\Request;

class DownloadsController extends Controller
{
    public function index(Request $request)
    {
        $query = CertificateDownload::with('certificate.participant');

        if ($search = $request->get('search')) {
            $query->whereHas('certificate', function ($q) use ($search) {
                $q->where('certificate_number', 'like', "%{$search}%")
                  ->orWhere('recipient_name', 'like', "%{$search}%");
            })->orWhere('ip_address', 'like', "%{$search}%");
        }

        $stats = [
            'certificates_issued' => \App\Models\Certificate::where('status', 'issued')->count(),
            'total_downloads'     => CertificateDownload::count(),
            'unique_downloads'    => CertificateDownload::distinct('certificate_id')->count('certificate_id'),
        ];
        
        $stats['not_downloaded'] = max(0, $stats['certificates_issued'] - $stats['unique_downloads']);
        $stats['download_rate']  = $stats['certificates_issued'] > 0 ? round(($stats['unique_downloads'] / $stats['certificates_issued']) * 100, 1) : 0;

        if ($period = $request->get('period')) {
            $days = match($period) {
                '7D' => 7,
                '30D' => 30,
                '90D' => 90,
                default => null,
            };
            if ($days) {
                $query->where('created_at', '>=', now()->subDays($days));
            }
        }

        $downloads = $query->latest()->paginate(25)->withQueryString();
        
        $chart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chart[] = [
                'label' => $date->format('M d'),
                'value' => CertificateDownload::whereDate('created_at', $date->toDateString())->count(),
            ];
        }

        return view('admin.downloads', compact('downloads', 'stats', 'chart'));
    }

    public function export(Request $request)
    {
        $query = CertificateDownload::with('certificate.participant');
        if ($period = $request->get('period')) {
            $days = match($period) { '7D'=>7, '30D'=>30, '90D'=>90, default=>null };
            if ($days) $query->where('created_at', '>=', now()->subDays($days));
        }

        $data = $query->latest()->get();
        $filename = 'downloads_report_' . date('Y-m-d') . '.csv';
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
        
        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Certificate ID', 'Participant Name', 'IP Address', 'User Agent', 'Downloaded At']);
            foreach ($data as $row) {
                fputcsv($file, [
                    $row->certificate->certificate_number,
                    $row->certificate->recipient_name,
                    $row->ip_address,
                    $row->user_agent,
                    $row->downloaded_at ? \Carbon\Carbon::parse($row->downloaded_at)->format('Y-m-d H:i:s') : ''
                ]);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
