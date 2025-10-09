<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\DummyData;

class ClientController extends Controller
{
    public function home()
    {
        $client = DummyData::clientProfile();
        $myJobs = DummyData::myJobsForClient($client['id']);
        $open = array_filter($myJobs, fn($j) => $j['status'] === 'open');
        return view('client.home', compact('client', 'myJobs', 'open'));
    }

    public function jobCreate()
    {
        $skills = DummyData::skills();
        return view('client.jobs.create', compact('skills'));
    }

    public function jobStore(Request $request)
    {
        // TODO: Persist job to DB with selected skills
        return redirect()->route('client.jobs.index')->with('status', 'Job created! // TODO: Save to DB');
    }

    public function jobsIndex()
    {
        $client = DummyData::clientProfile();
        $jobs = DummyData::myJobsForClient($client['id']);
        return view('client.jobs.index', compact('jobs'));
    }

    public function jobProposals(int $id)
    {
        $job = collect(DummyData::jobs())->firstWhere('id', $id);
        abort_if(!$job, 404);
        $proposals = DummyData::proposalsForJob($id);
        return view('client.proposals.index', compact('job', 'proposals'));
    }

    public function contractCreate()
    {
        $client = DummyData::clientProfile();
        $jobs = DummyData::myJobsForClient($client['id']);
        $proposals = DummyData::proposals();
        return view('client.contracts.create', compact('jobs', 'proposals'));
    }

    public function contractStore(Request $request)
    {
        // TODO: Create contract in DB from job + proposal
        return redirect()->route('client.home')->with('status', 'Contract created! // TODO: Save to DB');
    }

    public function proposalAccept(int $id)
    {
        // TODO: Mark proposal accepted in DB
        return back()->with('status', "Proposal #{$id} accepted! // TODO: Save to DB");
    }

    public function proposalReject(int $id)
    {
        // TODO: Mark proposal rejected in DB
        return back()->with('status', "Proposal #{$id} rejected! // TODO: Save to DB");
    }
}
