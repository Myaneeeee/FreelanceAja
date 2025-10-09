<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\DummyData;

class FreelancerController extends Controller
{
    public function home()
    {
        $profile = DummyData::freelancerProfile();
        $jobs = array_filter(DummyData::jobs(), fn($j) => $j['status'] === 'open');
        $activeContracts = DummyData::activeContractsForFreelancer();
        $pastContracts = DummyData::pastContractsForFreelancer();
        return view('freelancer.home', compact('profile', 'jobs', 'activeContracts', 'pastContracts'));
    }

    public function jobsIndex(Request $request)
    {
        $q = strtolower((string)$request->input('q', ''));
        $type = (string)$request->input('type', '');
        $skillId = (int)$request->input('skill_id', 0);
        $budgetMin = $request->input('budget_min');
        $budgetMax = $request->input('budget_max');

        $jobs = DummyData::jobs();

        $jobs = array_values(array_filter($jobs, function ($job) use ($q, $type, $skillId, $budgetMin, $budgetMax) {
            if ($q && !str_contains(strtolower($job['title'] . ' ' . $job['description']), $q)) {
                return false;
            }
            if ($type && $job['type'] !== $type) {
                return false;
            }
            if ($skillId && !in_array($skillId, $job['skills'] ?? [], true)) {
                return false;
            }
            if ($budgetMin !== null && (float)$job['budget'] < (float)$budgetMin) {
                return false;
            }
            if ($budgetMax !== null && (float)$job['budget'] > (float)$budgetMax) {
                return false;
            }
            return $job['status'] === 'open';
        }));

        $skills = DummyData::skills();

        return view('freelancer.jobs.index', compact('jobs', 'skills', 'q', 'type', 'skillId', 'budgetMin', 'budgetMax'));
    }

    public function jobShow(int $id)
    {
        $job = collect(DummyData::jobs())->firstWhere('id', $id);
        abort_if(!$job, 404);
        $skills = DummyData::skills();
        return view('freelancer.jobs.show', compact('job', 'skills'));
    }

    public function submitProposal(Request $request, int $id)
    {
        // TODO: Persist proposal
        // For now, pretend success and redirect back
        // Validate placeholder
        // $request->validate(['cover_letter' => 'required', 'bid_amount' => 'required|numeric']);
        return back()->with('status', 'Proposal submitted! // TODO: Persist to DB');
    }

    public function skillsEdit()
    {
        $profile = DummyData::freelancerProfile();
        $skills = DummyData::skills();
        return view('freelancer.skills', compact('profile', 'skills'));
    }

    public function skillsUpdate(Request $request)
    {
        // TODO: Update freelancer skills in DB
        return back()->with('status', 'Skills updated! // TODO: Save to DB');
    }

    public function contractsIndex()
    {
        $active = DummyData::activeContractsForFreelancer();
        $history = DummyData::pastContractsForFreelancer();
        return view('freelancer.contracts.index', compact('active', 'history'));
    }

    public function profileShow()
    {
        $profile = DummyData::freelancerProfile();
        return view('freelancer.profile.show', compact('profile'));
    }

    public function profileEdit()
    {
        $profile = DummyData::freelancerProfile();
        return view('freelancer.profile.edit', compact('profile'));
    }

    public function profileUpdate(Request $request)
    {
        // TODO: Update freelancer profile in DB
        return redirect()->route('freelancer.profile.show')->with('status', 'Profile updated! // TODO: Save to DB');
    }
}
