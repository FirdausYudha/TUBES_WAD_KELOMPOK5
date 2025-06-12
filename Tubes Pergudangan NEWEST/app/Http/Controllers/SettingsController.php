<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Show the settings form.
     */
    public function index()
    {
        // For demonstration, we can pass some dummy settings data
        $settings = [
            'site_name' => config('app.name'),
            'admin_email' => 'admin@example.com',
        ];
        return view('settings.index', compact('settings'));
    }

    /**
     * Save the settings.
     */
    public function update(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'admin_email' => 'required|email|max:255',
        ]);

        // For demonstration, just flash the data to session
        // In real app, save to database or config file
        session()->flash('success', 'Settings have been saved.');
        return redirect()->route('settings.index');
    }
}
