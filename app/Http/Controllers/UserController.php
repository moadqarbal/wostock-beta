<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;


class UserController extends Controller
{
    public function create()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' =>  'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        Auth::login($user);

        return to_route('dashboard.index')->with('success', 'Welcome ' . $user->name . '!');
    }

    public function login()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->boolean('remember');

        $key = Str::lower($request->email) . '|' . $request->ip();

        // إلا سالاو 20 محاولة
        if (RateLimiter::tooManyAttempts($key, 20)) {
            return back()->withErrors([
                'email' => 'تم تجاوز عدد محاولات تسجيل الدخول. حاول مرة أخرى بعد 3 أيام.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $remember)) {

            RateLimiter::clear($key);

            $request->session()->regenerate();

            return to_route('dashboard.index')
                ->with('success', 'Salut!');
        }

        // تسجيل المحاولة الفاشلة
        RateLimiter::hit($key, 60 * 60 * 24 * 3);

        // حساب المحاولات المتبقية
        $remaining = max(0, 20 - RateLimiter::attempts($key));

        return back()
            ->withErrors([
                'email' => "Les identifiants sont incorrects. Il vous reste {$remaining} tentative(s).",
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('users.login')->with('success', 'You have been logged out successfully!');
    }
}
