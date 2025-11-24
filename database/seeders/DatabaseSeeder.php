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
        // ==========================================
        // 1. MASTER DATA: SKILLS
        // ==========================================
        $skillsData = [
            ['id' => 1, 'name' => 'Laravel'],
            ['id' => 2, 'name' => 'PHP'],
            ['id' => 3, 'name' => 'JavaScript'],
            ['id' => 4, 'name' => 'Vue.js'],
            ['id' => 5, 'name' => 'React'],
            ['id' => 6, 'name' => 'Tailwind CSS'],
            ['id' => 7, 'name' => 'Bootstrap'],
            ['id' => 8, 'name' => 'MySQL'],
            ['id' => 9, 'name' => 'PostgreSQL'],
            ['id' => 10, 'name' => 'Python'],
        ];

        foreach ($skillsData as $s) {
            Skill::updateOrCreate(['id' => $s['id']], ['name' => $s['name']]);
        }

        // ==========================================
        // 2. USERS & PROFILES
        // ==========================================
        
        // --- User 1: Ricky (The Client) ---
        $ricky = User::create([
            'name' => 'Ricky',
            'email' => 'ricky@binus.edu',
            'password' => Hash::make('password'),
        ]);
        // Ricky's Client Profile (He posts jobs)
        $ricky->clientProfile()->create([
            'company_name' => 'Ricky Tech Solutions',
            'company_description' => 'A leading tech firm in Binus.',
            'website_url' => 'https://ricky.binus.edu',
        ]);
        // Ricky's Freelancer Profile (Empty/Default)
        $ricky->freelancerProfile()->create([
            'headline' => 'IT Consultant',
            'rate_per_hour' => 100,
        ]);


        // --- User 2: David (The Freelancer) ---
        $david = User::create([
            'name' => 'David',
            'email' => 'david@binus.edu',
            'password' => Hash::make('password'),
        ]);
        // David's Client Profile (Default)
        $david->clientProfile()->create([
            'company_name' => "David's Store",
        ]);
        // David's Freelancer Profile (He works)
        $davidProfile = $david->freelancerProfile()->create([
            'headline' => 'Senior Backend Developer',
            'bio' => 'Expert in Laravel and Database Optimization.',
            'portfolio_url' => 'https://david.dev',
            'rate_per_hour' => 50,
        ]);
        $davidProfile->skills()->sync([1, 2, 8, 9]); // Laravel, PHP, MySQL, Postgres


        // --- User 3: Visella (The Hybrid) ---
        $visella = User::create([
            'name' => 'Visella',
            'email' => 'visella@binus.edu',
            'password' => Hash::make('password'),
        ]);
        // Visella's Client Profile
        $visella->clientProfile()->create([
            'company_name' => 'Visella Design Studio',
            'website_url' => 'https://visella.art',
        ]);
        // Visella's Freelancer Profile
        $visellaProfile = $visella->freelancerProfile()->create([
            'headline' => 'UI/UX Designer & Frontend',
            'rate_per_hour' => 40,
        ]);
        $visellaProfile->skills()->sync([3, 5, 6]); // JS, React, Tailwind


        // ==========================================
        // 3. JOBS (Posted by Ricky & Visella)
        // ==========================================

        // Job 1: Ricky needs a Website (Fixed Price)
        $jobWebsite = Job::create([
            'client_profile_id' => $ricky->clientProfile->id,
            'title' => 'Build a Corporate Website',
            'description' => 'Need a full-stack developer to build a company profile.',
            'budget' => 5000.00,
            'type' => 'fixed_price',
            'status' => 'open',
            'deadline' => '2025-12-31',
            'created_at' => now()->subDays(5),
        ]);
        $jobWebsite->skills()->sync([1, 7]); // Laravel, Bootstrap

        // Job 2: Ricky needs API (Hourly)
        $jobApi = Job::create([
            'client_profile_id' => $ricky->clientProfile->id,
            'title' => 'Fix Slow API Response',
            'description' => 'Our API is taking 3s to load. Need optimization.',
            'budget' => 60.00, // hourly
            'type' => 'hourly',
            'status' => 'open',
            'deadline' => '2025-11-20',
            'created_at' => now()->subDays(2),
        ]);
        $jobApi->skills()->sync([2, 8]); // PHP, MySQL

        // Job 3: Visella needs a Python Script (Completed)
        $jobScript = Job::create([
            'client_profile_id' => $visella->clientProfile->id,
            'title' => 'Data Scraping Script',
            'description' => 'Scrape data from a news site.',
            'budget' => 200.00,
            'type' => 'fixed_price',
            'status' => 'completed',
            'created_at' => now()->subMonth(1),
        ]);
        $jobScript->skills()->sync([10]); // Python

        // ==========================================
        // 4. PROPOSALS
        // ==========================================

        // David applies to Ricky's Website Job
        $propDavidWebsite = Proposal::create([
            'job_id' => $jobWebsite->id,
            'freelancer_profile_id' => $davidProfile->id,
            'cover_letter' => 'I can build this using Laravel 11 and Bootstrap.',
            'bid_amount' => 4800.00,
            'status' => 'sent',
            'created_at' => now()->subDays(4),
        ]);

        // Visella applies to Ricky's Website Job (Competition!)
        Proposal::create([
            'job_id' => $jobWebsite->id,
            'freelancer_profile_id' => $visellaProfile->id,
            'cover_letter' => 'I can design a beautiful UI for this.',
            'bid_amount' => 5500.00,
            'status' => 'sent',
            'created_at' => now()->subDays(3),
        ]);

        // David applies to Ricky's API Job (Accepted)
        $propDavidApi = Proposal::create([
            'job_id' => $jobApi->id,
            'freelancer_profile_id' => $davidProfile->id,
            'cover_letter' => 'I am an expert in database indexing.',
            'bid_amount' => 60.00,
            'status' => 'accepted',
            'created_at' => now()->subDays(1),
        ]);

        // David applied to Visella's old job (Accepted)
        $propDavidScript = Proposal::create([
            'job_id' => $jobScript->id,
            'freelancer_profile_id' => $davidProfile->id,
            'cover_letter' => 'Done in 2 hours.',
            'bid_amount' => 200.00,
            'status' => 'accepted',
            'created_at' => now()->subMonth(1),
        ]);

        // ==========================================
        // 5. CONTRACTS
        // ==========================================

        // Contract: Ricky hires David for API (Active)
        Contract::create([
            'job_id' => $jobApi->id,
            'proposal_id' => $propDavidApi->id,
            'freelancer_profile_id' => $davidProfile->id,
            'client_profile_id' => $ricky->clientProfile->id,
            'final_price' => 60.00,
            'start_date' => now(),
            'status' => 'active',
        ]);

        // Contract: Visella hired David for Script (Completed)
        Contract::create([
            'job_id' => $jobScript->id,
            'proposal_id' => $propDavidScript->id,
            'freelancer_profile_id' => $davidProfile->id,
            'client_profile_id' => $visella->clientProfile->id,
            'final_price' => 200.00,
            'start_date' => now()->subMonth(1),
            'end_date' => now()->subWeeks(3),
            'status' => 'completed',
        ]);
    }
}