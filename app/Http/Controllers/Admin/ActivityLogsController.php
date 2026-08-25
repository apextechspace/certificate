<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use Illuminate\Http\Request;

class ActivityLogsController extends Controller
{
    public function index(Request $request)
    {
        $query = AdminActivityLog::with('user');

        if ($search = $request->get('search')) {
            $query->where('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
        }

        if ($type = $request->get('type')) {
            if ($type === 'admin') {
                $query->where('action', '!=', 'system');
            } elseif ($type === 'system') {
                $query->where('action', 'system');
            }
        }

        $logs = $query->latest()->paginate(50)->withQueryString();

        return view('admin.activity-logs', compact('logs'));
    }

    public function export(Request $request)
    {
        $query = AdminActivityLog::with('user');
        
        if ($search = $request->get('search')) {
            $query->where('description', 'like', "%{$search}%");
        }
        
        if ($type = $request->get('type')) {
            if ($type === 'admin') $query->where('action', '!=', 'system');
            elseif ($type === 'system') $query->where('action', 'system');
        }

        $data = $query->latest()->get();
        $filename = 'activity_logs_' . date('Y-m-d') . '.csv';
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
        
        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['User', 'Action', 'Description', 'IP Address', 'Date']);
            foreach ($data as $row) {
                fputcsv($file, [
                    $row->user ? $row->user->name : 'System',
                    $row->action,
                    $row->description,
                    $row->ip_address,
                    $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : ''
                ]);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}
