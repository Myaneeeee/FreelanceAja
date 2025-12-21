<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Proposal;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FreelancerController extends Controller
{
    public function home()
    {
        $user = Auth::user();
        $profile = $user->freelancerProfile;

        // Get Active Contracts (limit to 3 for dashboard)
        $activeContracts = $profile->contracts()
            ->with('job.clientProfile.user') // Eager load relationships
            ->where('status', 'active')
            ->latest()
            ->take(3)
            ->get();

        // Get recent job postings that match skills
        $mySkillIds = $profile->skills->pluck('id');
        
        $recommendedJobs = Job::with(['skills', 'clientProfile'])
            ->where('status', 'open')
            ->whereHas('skills', function($query) use ($mySkillIds) {
                $query->whereIn('skills.id', $mySkillIds); // Specify table name to avoid ambiguity
            })
            ->latest()
            ->limit(5)
            ->get();

        // Stats
        $totalEarnings = $profile->contracts()->where('status', 'completed')->sum('final_price');
        $proposalsCount = $profile->proposals()->where('status', 'sent')->count();

        return view('freelancer.home', compact('profile', 'recommendedJobs', 'activeContracts', 'totalEarnings', 'proposalsCount'));
    }

    public function jobsIndex(Request $request)
    {
        $query = Job::with(['skills', 'clientProfile.user'])->where('status', 'open');

        // Search
        if ($q = $request->input('q')) {
            $query->where(function($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // Filters
        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        if ($skillId = $request->input('skill_id')) {
            $query->whereHas('skills', function($q) use ($skillId) {
                $q->where('skills.id', $skillId);
            });
        }

        if ($min = $request->input('budget_min')) {
            $query->where('budget', '>=', $min);
        }
        if ($max = $request->input('budget_max')) {
            $query->where('budget', '<=', $max);
        }

        // Pagination is better than get() for lists
        $jobs = $query->latest()->paginate(10)->withQueryString();
        $skills = Skill::orderBy('name')->get();

        return view('freelancer.jobs.index', compact('jobs', 'skills'));
    }

    public function jobShow($id)
    {
        $job = Job::with(['skills', 'clientProfile.user', 'proposals'])->findOrFail($id);
        $profile = Auth::user()->freelancerProfile;

        // Check if user already submitted a proposal
        $existingProposal = Proposal::where('job_id', $job->id)
            ->where('freelancer_profile_id', $profile->id)
            ->first();

        return view('freelancer.jobs.show', compact('job', 'existingProposal'));
    }

    public function proposalsIndex(Request $request)
    {
        $profile = Auth::user()->freelancerProfile;

        $query = $profile->proposals()->with(['job.clientProfile.user']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('q') && $request->q != '') {
            $search = $request->q;
            $query->whereHas('job', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('clientProfile.user', function($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $proposals = $query->latest()->paginate(10)->withQueryString();

        return view('freelancer.proposals.index', compact('proposals'));
    }

    public function submitProposal(Request $request, $id)
    {
        $request->validate([
            'cover_letter' => 'required|string|min:25',
            'bid_amount' => 'required|numeric|min:1',
            'attachment' => 'nullable|file|mimes:pdf|max:2048', 
        ]);

        $job = Job::findOrFail($id);
        $profile = Auth::user()->freelancerProfile;

        if(Proposal::where('job_id', $job->id)->where('freelancer_profile_id', $profile->id)->exists()){
            return back()->withErrors(['msg' => 'You have already applied to this job.']);
        }

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('proposals', 'public');
        }

        Proposal::create([
            'job_id' => $job->id,
            'freelancer_profile_id' => $profile->id,
            'cover_letter' => $request->cover_letter,
            'bid_amount' => $request->bid_amount,
            'status' => 'sent',
            'attachment_path' => $path,
        ]);

        return redirect()->route('freelancer.jobs.index')->with('status', 'Proposal submitted successfully!');
    }

    public function skillsUpdate(Request $request)
    {
        $profile = Auth::user()->freelancerProfile;

        $selectedSkillIds = $request->input('skills', []);

        if ($request->filled('custom_skills')) {
            $customSkillsNames = explode(',', $request->input('custom_skills'));
            
            foreach ($customSkillsNames as $name) {
                $name = trim($name);
                if (!empty($name)) {
                    $skill = Skill::firstOrCreate(
                        ['name' => ucwords($name)], 
                        ['is_global' => false] 
                    );
                    
                    if (!in_array($skill->id, $selectedSkillIds)) {
                        $selectedSkillIds[] = $skill->id;
                    }
                }
            }
        }

        $profile->skills()->sync($selectedSkillIds);

        return redirect()->route('freelancer.home')->with('status', 'Skills updated successfully!');
    }

    public function skillsEdit()
    {
        $profile = Auth::user()->freelancerProfile;

        $mySkills = $profile->skills->pluck('id')->toArray();

        $skills = Skill::where('is_global', true)
            ->orWhereIn('id', $mySkills)
            ->orderBy('name')
            ->get();

        return view('freelancer.skills', compact('skills', 'mySkills'));
    }
    
    public function contractsIndex()
    {
        $profile = Auth::user()->freelancerProfile;
        
        $activeContracts = $profile->contracts()
            ->with(['job.clientProfile.user'])
            ->where('status', 'active')
            ->latest()
            ->get();
            
        $pastContracts = $profile->contracts()
            ->with(['job.clientProfile.user'])
            ->whereIn('status', ['completed', 'cancelled', 'disputed'])
            ->latest()
            ->get();

        return view('freelancer.contracts.index', compact('activeContracts', 'pastContracts'));
    }

    public function profileShow()
    {
        $profile = Auth::user()->freelancerProfile->load('skills', 'user');
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
            'headline' => 'required|string|max:100',
            'rate_per_hour' => 'required|numeric|min:0',
            'portfolio_url' => 'nullable|url',
            'bio' => 'nullable|string|max:1000'
        ]);

        $user = Auth::user();
        
        $user->freelancerProfile()->update([
            'headline' => $request->headline,
            'rate_per_hour' => $request->rate_per_hour,
            'bio' => $request->bio,
            'portfolio_url' => $request->portfolio_url
        ]);

        return redirect()->route('freelancer.profile.show')->with('status', 'Profile updated!');
    }
}