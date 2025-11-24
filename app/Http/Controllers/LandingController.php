<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Skill;
use Illuminate\Http\Request;
use App\Support\DummyData;

class LandingController extends Controller
{
    public function index()
    {
        // Real DB Queries
        $stats = [
            'jobs_open'   => Job::where('status', 'open')->count(),
            // Since we removed 'role', we count Profiles to know how many Freelancers/Clients exist
            'freelancers' => \App\Models\FreelancerProfile::count(),
            'clients'     => \App\Models\ClientProfile::count(),
        ];

        // Get 5 random skills for the tags on the landing page
        $skills = Skill::inRandomOrder()->limit(5)->get();

        return view('landing', compact('stats', 'skills'));
    }
}
