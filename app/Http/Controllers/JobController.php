<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Proposal;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::getDummyData(10);
        return view('jobs.index', compact('jobs'));
    }

    public function show($id)
    {
        $job = Job::getDummyData(1)[0];
        $job['id'] = $id;
        $proposals = Proposal::getDummyData(3);
        return view('jobs.show', compact('job', 'proposals'));
    }
}
