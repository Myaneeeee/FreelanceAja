<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Job;
use App\Models\Proposal;
use App\Models\Skill;
use Illuminate\Http\Request;
use App\Support\DummyData;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function home()
    {

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $client = $user->clientProfile;
        $myJobs = $client->jobs()->latest()->get()->toArray();
        $open   = $client->jobs()->where('status', 'open')->get()->toArray();

        return view('client.home', compact('client', 'myJobs', 'open'));
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
            'description' => 'required|string',
            'budget' => 'required|numeric|min:1',
            'type' => 'required|in:fixed_price,hourly',
            'deadline' => 'required|date',
            'skills' => 'array'
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $job = $user->clientProfile->jobs()->create([
            'title' => $request->title,
            'description' => $request->description,
            'budget' => $request->budget,
            'type' => $request->type,
            'deadline' => $request->deadline,
            'status' => 'open'
        ]);

        if ($request->has('skills')) {
            $job->skills()->sync($request->skills);
        }

        return redirect()->route('client.jobs.index')->with('status', 'Job posted successfully!');
    }

    public function jobsIndex()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $jobs = $user->clientProfile->jobs()->latest()->get();
        
        return view('client.jobs.index', compact('jobs'));
    }

    public function jobProposals(int $id)
    {
        // Ensure the job belongs to the logged-in client
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $job = $user->clientProfile->jobs()->with(['proposals.freelancerProfile.user'])->findOrFail($id);
        $proposals = $job->proposals;

        return view('client.proposals.index', compact('job', 'proposals'));
    }

    public function contractCreate()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Get jobs that have accepted proposals but no active contract
        $jobs = $user->clientProfile->jobs()->whereHas('proposals', function($q) {
            $q->where('status', 'accepted');
        })->get();

        // Get all accepted proposals for this client's jobs
        $proposals = Proposal::whereHas('job', function($q) use ($user) {
            $q->where('client_profile_id', $user->clientProfile->id);
        })->where('status', 'accepted')->get();

        return view('client.contracts.create', compact('jobs', 'proposals'));
    }

    public function contractStore(Request $request)
    {
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'proposal_id' => 'required|exists:proposals,id',
            'final_price' => 'required|numeric',
            'start_date' => 'required|date',
        ]);

        $proposal = Proposal::findOrFail($request->proposal_id);
        
        /** @var \App\Models\User $user */
        $user = Auth::user();

        Contract::create([
            'job_id' => $request->job_id,
            'proposal_id' => $request->proposal_id,
            'freelancer_profile_id' => $proposal->freelancer_profile_id,
            'client_profile_id' => $user->clientProfile->id,
            'final_price' => $request->final_price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'active'
        ]);

        // Update job status
        $job = Job::find($request->job_id);
        $job->status = 'in_progress';
        $job->save();

        return redirect()->route('client.home')->with('status', 'Contract started successfully!');
    }

    public function proposalAccept(int $id)
    {
        $proposal = Proposal::findOrFail($id);
        $proposal->status = 'accepted';
        $proposal->save();

        return back()->with('status', "Proposal accepted! You can now create a contract.");
    }

    public function proposalReject(int $id)
    {
        $proposal = Proposal::findOrFail($id);
        $proposal->status = 'rejected';
        $proposal->save();

        return back()->with('status', "Proposal rejected.");
    }
}
