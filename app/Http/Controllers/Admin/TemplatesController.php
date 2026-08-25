<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificateTemplate;
use Illuminate\Http\Request;

class TemplatesController extends Controller
{
    public function index(Request $request)
    {
        $templates = CertificateTemplate::latest()->get();

        // If no templates exist, we create a default one for display purposes
        if ($templates->isEmpty()) {
            $templates->push(new CertificateTemplate([
                'id' => 1,
                'name' => 'Umera Default',
                'description' => 'The standard Umera certificate template.',
                'background_image_path' => 'templates/umera_default.png',
                'is_active' => true,
            ]));
        }

        return view('admin.templates', compact('templates'));
    }
}
