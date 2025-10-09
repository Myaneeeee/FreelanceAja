<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Support\DummyData;

class LandingController extends Controller
{
    public function index()
    {
        // TODO: Pull stats from DB
        $stats = [
            'jobs_open' => count(array_filter(DummyData::jobs(), fn ($j) => $j['status'] === 'open')),
            'freelancers' => 1, // TODO: DB count
            'clients' => 1, // TODO: DB count
        ];

        return view('landing', [
            'stats' => $stats,
        ]);
    }
}
