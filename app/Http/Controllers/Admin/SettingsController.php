<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Setting;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $settings = [
            'org_name' => Setting::get('org_name', 'Umera Certificate Manager'),
            'support_email' => Setting::get('support_email', 'support@umera.ng'),
        ];
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'org_name' => 'required|string|max:255',
            'support_email' => 'required|email|max:255',
        ]);

        Setting::set('org_name', $request->input('org_name'));
        Setting::set('support_email', $request->input('support_email'));

        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully.');
    }
}
