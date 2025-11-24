<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('landing'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // --- REGISTER ---
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 1. Create the User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 2. Auto-create an empty Client Profile
        // We set a default company name based on their user name
        $user->clientProfile()->create([
            'company_name' => $request->name . "'s Company", 
            'website_url'  => null,
        ]);

        // 3. Auto-create an empty Freelancer Profile
        // We set default values to avoid null issues
        $user->freelancerProfile()->create([
            'headline'      => 'New Freelancer',
            'rate_per_hour' => 0,
            'bio'           => null,
            'portfolio_url' => null,
        ]);

        Auth::login($user);

        return redirect()->route('landing')->with('status', 'Account created! You can now hire or work.');
    }

    // --- LOGOUT ---
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}
