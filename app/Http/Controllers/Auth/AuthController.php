<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    use LogActivity;
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('dashboard.login.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        // Validate the request
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to log in
        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            $this->logActivity('user_login', "تم تسجيل الدخول بالبيانات: {$credentials['email']} بنجاح");

            return redirect()->intended('/users');
        }

        // Return back with error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}