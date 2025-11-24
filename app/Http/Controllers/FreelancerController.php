<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Proposal;
use App\Models\Skill;
use Illuminate\Http\Request;
use App\Support\DummyData;
use Illuminate\Support\Facades\Auth;

class FreelancerController extends Controller
{
    public function home()
    {
        $user = Auth::user();
        
        $profile = $user->freelancerProfile;

        // Get Active and Past contracts
        $activeContracts = $profile->contracts()->where('status', 'active')->get()->toArray();
        $pastContracts   = $profile->contracts()->whereIn('status', ['completed', 'cancelled', 'disputed'])->get()->toArray();

        // Suggest jobs based on skills (Simple recommendation system)
        $mySkillIds = $profile->skills->pluck('id');
        
        $jobs = Job::where('status', 'open')
            ->whereHas('skills', function($query) use ($mySkillIds) {
                $query->whereIn('id', $mySkillIds);
            })
            ->limit(5)
            ->get()
            ->toArray();

        return view('freelancer.home', compact('profile', 'jobs', 'activeContracts', 'pastContracts'));
    }

    public function jobsIndex(Request $request)
    {
        // Start a query builder
        $query = Job::with('skills')->where('status', 'open');

        // 1. Search by Title or Description
        if ($q = $request->input('q')) {
            $query->where(function($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // 2. Filter by Type
        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        // 3. Filter by Skill
        if ($skillId = $request->input('skill_id')) {
            $query->whereHas('skills', function($q) use ($skillId) {
                $q->where('id', $skillId);
            });
        }

        // 4. Filter by Budget
        if ($min = $request->input('budget_min')) {
            $query->where('budget', '>=', $min);
        }
        if ($max = $request->input('budget_max')) {
            $query->where('budget', '<=', $max);
        }

        $jobs = $query->latest()->get();
        $skills = Skill::orderBy('name')->get();

        // Pass back inputs so filters stay filled
        return view('freelancer.jobs.index', [
            'jobs' => $jobs, 
            'skills' => $skills,
            'q' => $request->input('q'),
            'type' => $request->input('type'),
            'skillId' => $request->input('skill_id'),
            'budgetMin' => $request->input('budget_min'),
            'budgetMax' => $request->input('budget_max'),
        ]);
    }

    public function jobShow($id)
    {
        $jobModel = Job::with('skills', 'clientProfile')->findOrFail($id);
        $job = $jobModel->toArray();
        $job['skills'] = $jobModel->skills->pluck('id')->toArray();
        $skills = Skill::orderBy('name')->get();

        return view('freelancer.jobs.show', compact('job', 'skills'));
    }

    public function submitProposal(Request $request, $id)
    {
        $request->validate([
            'cover_letter' => 'required|string',
            'bid_amount' => 'required|numeric|min:1',
        ]);

        $job = Job::findOrFail($id);
        $profile = Auth::user()->freelancerProfile;

        Proposal::create([
            'job_id' => $job->id,
            'freelancer_profile_id' => $profile->id,
            'cover_letter' => $request->cover_letter,
            'bid_amount' => $request->bid_amount,
            'status' => 'sent',
        ]);

        return redirect()->route('freelancer.jobs.index')->with('status', 'Proposal submitted successfully!');
    }

    public function skillsEdit()
    {
        $profile = Auth::user()->freelancerProfile;
        $skills = Skill::orderBy('name')->get();
        
        // Frontend expects 'profile' array with 'skills' key containing IDs
        // We format it to match your frontend logic
        $profileData = $profile->toArray();
        $profileData['skills'] = $profile->skills->pluck('id')->toArray();

        return view('freelancer.skills', [
            'profile' => $profileData, // Array for blade compatibility
            'skills' => $skills
        ]);
    }

    public function skillsUpdate(Request $request)
    {
        $profile = Auth::user()->freelancerProfile;
        $profile->skills()->sync($request->input('skills', []));

        return back()->with('status', 'Skills updated successfully!');
    }

    public function contractsIndex()
    {
        $profile = Auth::user()->freelancerProfile;
        $active = $profile->contracts()->where('status', 'active')->get();
        $history = $profile->contracts()->whereNot('status', 'active')->get();

        return view('freelancer.contracts.index', compact('active', 'history'));
    }

    public function profileShow()
    {
        $profile = Auth::user()->freelancerProfile;
        return view('freelancer.profile.show', compact('profile'));
    }

    public function profileEdit()
    {
        $profile = Auth::user()->freelancerProfile;
        return view('freelancer.profile.edit', compact('profile'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'headline' => 'required|string|max:255',
            'rate_per_hour' => 'required|numeric|min:0',
            'portfolio_url' => 'nullable|url',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $user->freelancerProfile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'headline' => $request->headline,
                'rate_per_hour' => $request->rate_per_hour,
                'bio' => $request->bio,
                'portfolio_url' => $request->portfolio_url
            ]
        );

        return redirect()->route('freelancer.profile.show')->with('status', 'Profile updated!');
    }
}
