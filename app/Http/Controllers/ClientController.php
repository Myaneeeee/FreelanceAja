<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Job;
use App\Models\Proposal;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function home()
    {
        $user = Auth::user();
        $client = $user->clientProfile;

        // Stats for Dashboard
        $activeJobsCount = $client->jobs()->where('status', 'in_progress')->count();
        $openJobsCount = $client->jobs()->where('status', 'open')->count();
        $totalSpent = $client->contracts()->where('status', 'completed')->sum('final_price');

        // Recent Proposals (pending review)
        $recentProposals = Proposal::whereHas('job', function($q) use ($client) {
                $q->where('client_profile_id', $client->id);
            })
            ->where('status', 'sent')
            ->with(['job', 'freelancerProfile.user'])
            ->latest()
            ->take(5)
            ->get();

        // Active Contracts (Running projects)
        $activeContracts = $client->contracts()
            ->with(['job', 'freelancerProfile.user'])
            ->where('status', 'active')
            ->latest()
            ->get();

        return view('client.home', compact('client', 'activeJobsCount', 'openJobsCount', 'totalSpent', 'recentProposals', 'activeContracts'));
    }

    public function jobCreate()
    {
        $skills = Skill::orderBy('name')->get();
        return view('client.jobs.create', compact('skills'));
    }

    public function jobStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:50',
            'budget' => 'required|numeric|min:5',
            'type' => 'required|in:fixed_price,hourly',
            'deadline' => 'required|date|after:today',
            'skills' => 'required|array|min:1',
            'skills.*' => 'exists:skills,id'
        ]);

        $user = Auth::user();

        $job = $user->clientProfile->jobs()->create([
            'title' => $request->title,
            'description' => $request->description,
            'budget' => $request->budget,
            'type' => $request->type,
            'deadline' => $request->deadline,
            'status' => 'open'
        ]);

        $job->skills()->sync($request->skills);

        return redirect()->route('client.jobs.index')->with('status', 'Job posted successfully! Freelancers can now apply.');
    }

    public function jobsIndex()
    {
        $user = Auth::user();
        
        // Get jobs with proposal counts
        $jobs = $user->clientProfile->jobs()
            ->withCount(['proposals', 'proposals as new_proposals_count' => function($query) {
                $query->where('status', 'sent');
            }])
            ->latest()
            ->paginate(10);
        
        return view('client.jobs.index', compact('jobs'));
    }

    public function jobProposals(int $id)
    {
        $user = Auth::user();
        
        // Ensure job belongs to client
        $job = $user->clientProfile->jobs()
            ->with(['proposals.freelancerProfile.user', 'proposals' => function($q) {
                // Sort proposals: Accepted first, then new ones
                $q->orderByRaw("FIELD(status, 'accepted', 'sent', 'rejected')");
            }])
            ->findOrFail($id);

        return view('client.proposals.index', compact('job'));
    }

    public function proposalAccept(int $id)
    {
        $proposal = Proposal::findOrFail($id);
        
        // Security check: Ensure this proposal belongs to a job owned by the auth user
        if ($proposal->job->client_profile_id !== Auth::user()->clientProfile->id) {
            abort(403);
        }

        $proposal->status = 'accepted';
        $proposal->save();

        // Redirect to contract creation immediately
        return redirect()->route('client.contracts.create', ['proposal_id' => $proposal->id])
            ->with('status', "Proposal accepted! Please review and finalize the contract details.");
    }

    public function proposalReject(int $id)
    {
        $proposal = Proposal::findOrFail($id);
        
        if ($proposal->job->client_profile_id !== Auth::user()->clientProfile->id) {
            abort(403);
        }

        $proposal->status = 'rejected';
        $proposal->save();

        return back()->with('status', "Proposal rejected.");
    }

    public function contractCreate(Request $request)
    {
        // If a specific proposal is passed (via Accept flow), autofill it
        $selectedProposalId = $request->get('proposal_id');
        $user = Auth::user();

        // Get all accepted proposals that don't have a contract yet
        $acceptedProposals = Proposal::whereHas('job', function($q) use ($user) {
                $q->where('client_profile_id', $user->clientProfile->id);
            })
            ->where('status', 'accepted')
            ->whereDoesntHave('contract')
            ->with(['job', 'freelancerProfile.user'])
            ->get();

        if($acceptedProposals->isEmpty()) {
            return redirect()->route('client.jobs.index')->withErrors(['msg' => 'You have no accepted proposals waiting for contracts.']);
        }

        return view('client.contracts.create', compact('acceptedProposals', 'selectedProposalId'));
    }

    public function contractStore(Request $request)
    {
        $request->validate([
            'proposal_id' => 'required|exists:proposals,id',
            'final_price' => 'required|numeric|min:1',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        $proposal = Proposal::findOrFail($request->proposal_id);
        $user = Auth::user();

        // Double check ownership
        if ($proposal->job->client_profile_id !== $user->clientProfile->id) {
            abort(403);
        }

        Contract::create([
            'job_id' => $proposal->job_id,
            'proposal_id' => $proposal->id,
            'freelancer_profile_id' => $proposal->freelancer_profile_id,
            'client_profile_id' => $user->clientProfile->id,
            'final_price' => $request->final_price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'active'
        ]);

        // Update job status to in_progress
        $proposal->job->update(['status' => 'in_progress']);

        return redirect()->route('client.home')->with('status', 'Contract started successfully! Work can begin.');
    }
}