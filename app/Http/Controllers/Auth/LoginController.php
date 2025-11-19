<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Role-based redirection
            if ($user->isAdmin()) {
            return redirect()->intended('/admin');
            } elseif ($user->isPromoter()) {
                // Check if promoter is approved
                if ($user->promoter && $user->promoter->status === 'approved') {
                    return redirect()->intended('/promoter/dashboard');
                } else {
                    return redirect()->route('promoter.pending');
                }
            } elseif ($user->isClient()) {
                return redirect()->intended('/my/dashboard');
            }
            
            // Default fallback
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

