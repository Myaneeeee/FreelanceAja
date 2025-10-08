<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;

class HomeController extends Controller
{
    public function index()
    {
        $jobs = Job::getDummyData(10);
        return view('landing', compact('jobs'));
    }
}
