<?php

namespace App\Http\Controllers;

use App\Models\ClientProfile;
use App\Models\FreelancerProfile;
use App\Models\Job;
use App\Models\Skill;
use Auth;
use Illuminate\Http\Request;
use App\Support\DummyData;

class LandingController extends Controller
{
    public function index()
    {
        // 1. Check if user is logged in
        if (Auth::check()) {
            $role = session('active_role', 'freelancer');
            return redirect()->route($role . '.home');
        }

        $stats = [
            'jobs_open'   => Job::where('status', 'open')->count(),
            'freelancers' => FreelancerProfile::count(),
            'clients'     => ClientProfile::count(),
        ];

        $skills = Skill::inRandomOrder()->limit(10)->get();

        $recentJobs = Job::with('clientProfile')
                         ->where('status', 'open')
                         ->latest()
                         ->take(3)
                         ->get();

        return view('landing', compact('stats', 'skills', 'recentJobs'));
    }
}
