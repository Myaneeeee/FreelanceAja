<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Skill;
use App\Models\Job;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            // Tech
            'Laravel', 'PHP', 'React', 'Vue.js', 'MySQL', 'Python', 'Node.js', 
            'WordPress', 'Shopify', 'AWS', 'DevOps', 'Mobile App Dev',
            // Design
            'Graphic Design', 'UI/UX Design', 'Logo Design', 'Photoshop', 'Illustrator', 
            'Figma', 'Video Editing', 'Animation',
            // Writing
            'Content Writing', 'Copywriting', 'SEO Writing', 'Technical Writing', 
            'Translation', 'Proofreading', 'Ghostwriting',
            // Marketing
            'Social Media Marketing', 'SEO', 'Email Marketing', 'Google Ads', 
            'Facebook Ads', 'Content Strategy',
            // Admin / Support
            'Virtual Assistant', 'Data Entry', 'Customer Support', 'Project Management', 
            'Lead Generation', 'Excel'
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(
                ['name' => $skill],
                ['is_global' => true]
            );
        }

        $clientUser = User::create([
            'name' => 'John Client',
            'email' => 'client@example.com',
            'password' => Hash::make('password'),
            'role' => 'client',
        ]);

        $clientProfile = $clientUser->clientProfile()->create([
            'company_name' => 'Tech Corp',
            'company_description' => 'A global technology innovator.',
            'website_url' => 'https://techcorp.com',
        ]);
        
        $clientUser->freelancerProfile()->create(['headline' => 'Client Account']);

        Job::create([
            'client_profile_id' => $clientProfile->id,
            'title' => 'Build a Laravel Website',
            'description' => 'Need a developer to build a corporate website using Laravel. Must know MySQL and Bootstrap.',
            'budget' => 5000.00,
            'type' => 'fixed_price',
            'status' => 'open',
            'deadline' => now()->addDays(30),
        ])->skills()->sync(Skill::whereIn('name', ['Laravel', 'MySQL', 'PHP'])->pluck('id'));
        
        Job::create([
            'client_profile_id' => $clientProfile->id,
            'title' => 'Logo Design for Startup',
            'description' => 'Looking for a creative logo for a coffee shop. Minimalist style preferred.',
            'budget' => 500.00,
            'type' => 'fixed_price',
            'status' => 'open',
            'deadline' => now()->addDays(7),
        ])->skills()->sync(Skill::whereIn('name', ['Graphic Design', 'Logo Design', 'Illustrator'])->pluck('id'));

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
        
        $freelancerUser->clientProfile()->create(['company_name' => 'Jane Freelancer']);
    }
}