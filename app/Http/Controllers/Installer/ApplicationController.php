<?php

namespace App\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        return view('installer.application');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'app_name' => ['required', 'string', 'max:255'],
            'app_url' => ['required', 'url', 'max:255'],
        ]);

        session([
            'installer.application' => $validated,
        ]);

        return redirect()
            ->route('installer.mail')
            ->with('success', 'Application settings saved.');
    }
}