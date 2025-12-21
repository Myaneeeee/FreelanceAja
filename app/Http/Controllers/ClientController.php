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

        return view('client.home', compact('client', 'activeJobsCount', 'openJobsCount', 'recentProposals', 'activeContracts'));
    }

    public function contractsIndex(Request $request)
    {
        $user = Auth::user();
        $query = $user->clientProfile->contracts()->with(['job', 'freelancerProfile.user']);

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('q') && $request->q != '') {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->whereHas('job', function($j) use ($search) {
                    $j->where('title', 'like', "%{$search}%");
                })
                ->orWhereHas('freelancerProfile.user', function($u) use ($search) {
                    $u->where('name', 'like', "%{$search}%");
                });
            });
        }

        $contracts = $query->latest()->paginate(10)->withQueryString();
        
        $activeCount = $user->clientProfile->contracts()->where('status', 'active')->count();
        $allCount = $user->clientProfile->contracts()->count();

        return view('client.contracts.index', compact('contracts', 'activeCount', 'allCount'));
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

    public function jobsIndex(Request $request)
    {
        $user = Auth::user();
        
        $query = $user->clientProfile->jobs();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('q') && $request->q != '') {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        $jobs = $query->withCount(['proposals', 'proposals as new_proposals_count' => function($q) {
                $q->where('status', 'sent');
            }])
            ->latest()
            ->paginate(10)
            ->withQueryString();
        
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

        return back()->with('status', 'Proposal rejected.'); 
    }

    public function contractCreate(Request $request)
    {
        $selectedProposalId = $request->get('proposal_id');
        $user = Auth::user();

        $acceptedProposals = Proposal::whereHas('job', function($q) use ($user) {
                $q->where('client_profile_id', $user->clientProfile->id);
            })
            ->where('status', 'accepted')
            ->whereDoesntHave('contract')
            ->with(['job', 'freelancerProfile.user'])
            ->get();
        
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

        $proposal->job->update(['status' => 'in_progress']);

        return redirect()->route('client.home')->with('status', 'Contract started successfully! Work can begin.');
    }
}