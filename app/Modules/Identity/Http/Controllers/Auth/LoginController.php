<?php

namespace App\Modules\Identity\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController
{
    /**
     * Display the login form.
     */
    public function show(): View
    {
        return view('identity.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirect to home page for now
            // Admin dashboard redirection will be added after /admin route is implemented
            if (Auth::user()?->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }

            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'اطلاعات وارد شده صحیح نیست.',
        ])->onlyInput('email');
    }
}