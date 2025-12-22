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
            $role = Auth::user()->role ?? 'freelancer';
            session(['active_role' => $role]);

            return redirect()->intended(route($role . '.home'));
        }

        return back()->withErrors([
            'email' => __('auth.failed'),
        ])->onlyInput('email');
    }

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
            'role' => 'required|in:freelancer,client',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:20',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($request->role === 'client') {
            $user->clientProfile()->create([
                'company_name' => $request->name,
                'contact_email' => $request->contact_email,
                'contact_phone' => $request->contact_phone,
                'company_description' => null,
                'website_url'  => null,
            ]);
        } else {
            $user->freelancerProfile()->create([
                'headline'      => __('freelancer.new_freelancer'),
                'rate_per_hour' => 0,
                'contact_email' => $request->contact_email,
                'contact_phone' => $request->contact_phone,
                'bio'           => null,
                'portfolio_url' => null,
            ]);
        }

        Auth::login($user);

        session(['active_role' => $request->role]);

        return redirect()->route($request->role . '.home')->with('status', __('freelancer.account_created_welcome'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}
