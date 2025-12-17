<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Skill;
use App\Models\Job;
use App\Models\Proposal;
use App\Models\Contract;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $skills = ['Laravel', 'PHP', 'React', 'MySQL', 'Python'];
        foreach ($skills as $skill) {
            Skill::firstOrCreate(['name' => $skill]);
        }

        $clientUser = User::create([
            'name' => 'John Client',
            'email' => 'client@example.com',
            'password' => Hash::make('password'),
            'role' => 'client',
        ]);

        $clientProfile = $clientUser->clientProfile()->create([
            'company_name' => 'Tech Corp',
            'company_description' => 'A technology company.',
            'website_url' => 'https://techcorp.com',
        ]);

        $clientUser->freelancerProfile()->create([
            'headline' => 'Client Account', 
            'bio' => 'I hire people.', 
            'rate_per_hour' => 0
        ]);

        $job1 = Job::create([
            'client_profile_id' => $clientProfile->id,
            'title' => 'Build a Laravel Website',
            'description' => 'Need a developer to build a corporate website using Laravel.',
            'budget' => 5000.00,
            'type' => 'fixed_price',
            'status' => 'open',
            'deadline' => now()->addDays(30),
        ]);
        
        $job2 = Job::create([
            'client_profile_id' => $clientProfile->id,
            'title' => 'Fix API Issues',
            'description' => 'Debug and fix slow API endpoints.',
            'budget' => 50.00,
            'type' => 'hourly',
            'status' => 'open',
            'deadline' => now()->addDays(14),
        ]);

        $freelancerUser = User::create([
            'name' => 'Jane Freelancer',
            'email' => 'freelancer@example.com',
            'password' => Hash::make('password'),
            'role' => 'freelancer',
        ]);

        $freelancerUser->freelancerProfile()->create([
            'headline' => 'Full Stack Developer',
            'bio' => 'Experienced in Laravel and React.',
            'rate_per_hour' => 30.00,
        ]);

        $freelancerUser->clientProfile()->create([
            'company_name' => 'Jane Freelancer',
        ]);
    }
}
