<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        //
    }

    public function edit()
    {
        $dashboard = Dashboard::first();

        return view('dashboard.edit', compact('dashboard'));
    }

    /**
     * Update authenticated user's profile.
     */
    public function updateProfile(Request $request)
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],

        'email' => [
            'required',
            'string',
            'email',
            'max:255',
            'unique:users,email,' . $request->user()->id,
        ],

        'app_name' => ['required', 'string', 'max:255'],
    ]);

    $request->user()->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
    ]);

    $dashboard = Dashboard::first();

    if ($dashboard) {
        $dashboard->update([
            'app_name' => $validated['app_name'],
        ]);
    } else {
        Dashboard::create([
            'app_name' => $validated['app_name'],
        ]);
    }

    return to_route('dashboard.edit')
        ->with('success', 'Votre profil a été mis à jour avec succès.');
}

    /**
     * Update authenticated user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => [
                'required',
                'current_password',
            ],

            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return to_route('settings.edit')
            ->with('success', 'Votre mot de passe a été mis à jour avec succès.');
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
