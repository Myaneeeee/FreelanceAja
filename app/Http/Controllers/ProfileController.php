<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FreelancerProfile;
use App\Models\ClientProfile;
use App\Models\User;

class ProfileController extends Controller
{
    public function showFreelancer($id)
    {
        $profile = FreelancerProfile::getDummyData(1)[0];
        $profile['id'] = $id;
        $user = User::getDummyData(1)[0];
        $skills = \App\Models\Skill::getDummyData(5);
        return view('profiles.freelancer', compact('profile', 'user', 'skills'));
    }

    public function showClient($id)
    {
        $profile = ClientProfile::getDummyData(1)[0];
        $profile['id'] = $id;
        $user = User::getDummyData(1)[0];
        return view('profiles.client', compact('profile', 'user'));
    }
}
