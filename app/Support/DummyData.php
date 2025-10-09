<?php

namespace App\Support;

class DummyData
{
    public static function skills(): array
    {
        return [
            ['id' => 1, 'name' => 'Laravel'],
            ['id' => 2, 'name' => 'PHP'],
            ['id' => 3, 'name' => 'JavaScript'],
            ['id' => 4, 'name' => 'Vue.js'],
            ['id' => 5, 'name' => 'React'],
            ['id' => 6, 'name' => 'Tailwind CSS'],
            ['id' => 7, 'name' => 'Bootstrap'],
            ['id' => 8, 'name' => 'MySQL'],
            ['id' => 9, 'name' => 'PostgreSQL'],
        ];
    }

    public static function clientProfile(): array
    {
        return [
            'id' => 1,
            'user_id' => 1,
            'company_name' => 'Acme Corp',
            'company_description' => 'We build amazing products.',
            'website_url' => 'https://davidchristian.vercel.app',
        ];
    }

    public static function freelancerProfile(): array
    {
        return [
            'id' => 1,
            'user_id' => 2,
            'headline' => 'Full-Stack Developer',
            'bio' => '5+ years building web apps with Laravel and modern JS.',
            'portfolio_url' => 'https://davidchristian.vercel.app',
            'rate_per_hour' => 45.00,
            'skills' => [1, 2, 3, 7],
        ];
    }

    public static function jobs(): array
    {
        // type: fixed_price | hourly
        // status: open | in_progress | completed | cancelled
        return [
            [
                'id' => 101,
                'client_profile_id' => 1,
                'title' => 'Build a Company Website',
                'description' => 'Create a responsive marketing site with CMS.',
                'budget' => 2000.00,
                'type' => 'fixed_price',
                'status' => 'open',
                'deadline' => '2025-12-31',
                'skills' => [1, 7, 8],
                'created_at' => '2025-10-01',
            ],
            [
                'id' => 102,
                'client_profile_id' => 1,
                'title' => 'API Development for Mobile App',
                'description' => 'Secure REST API with auth and rate limits.',
                'budget' => 50.00, // hourly
                'type' => 'hourly',
                'status' => 'open',
                'deadline' => '2025-11-15',
                'skills' => [1, 2, 8, 9],
                'created_at' => '2025-10-03',
            ],
            [
                'id' => 103,
                'client_profile_id' => 1,
                'title' => 'Dashboard with Charts',
                'description' => 'Build a dashboard with charts and filters.',
                'budget' => 1500.00,
                'type' => 'fixed_price',
                'status' => 'in_progress',
                'deadline' => '2025-10-30',
                'skills' => [3, 5],
                'created_at' => '2025-09-25',
            ],
        ];
    }

    public static function proposals(): array
    {
        // status: sent | accepted | rejected
        return [
            [
                'id' => 201,
                'job_id' => 101,
                'freelancer_profile_id' => 1,
                'cover_letter' => 'I can deliver in 2 weeks with SEO best practices.',
                'bid_amount' => 1800.00,
                'status' => 'sent',
                'created_at' => '2025-10-04',
            ],
            [
                'id' => 202,
                'job_id' => 102,
                'freelancer_profile_id' => 1,
                'cover_letter' => 'Experienced in secure APIs, can start immediately.',
                'bid_amount' => 55.00,
                'status' => 'accepted',
                'created_at' => '2025-10-05',
            ],
        ];
    }

    public static function contracts(): array
    {
        // status: active | completed | disputed
        return [
            [
                'id' => 301,
                'job_id' => 102,
                'proposal_id' => 202,
                'freelancer_profile_id' => 1,
                'client_profile_id' => 1,
                'final_price' => 55.00, // hourly rate
                'start_date' => '2025-10-06',
                'end_date' => null,
                'status' => 'active',
            ],
            [
                'id' => 302,
                'job_id' => 103,
                'proposal_id' => 203,
                'freelancer_profile_id' => 1,
                'client_profile_id' => 1,
                'final_price' => 1500.00,
                'start_date' => '2025-09-26',
                'end_date' => '2025-10-02',
                'status' => 'completed',
            ],
        ];
    }

    public static function myJobsForClient(int $clientProfileId = 1): array
    {
        return array_values(array_filter(self::jobs(), fn ($j) => $j['client_profile_id'] === $clientProfileId));
    }

    public static function proposalsForJob(int $jobId): array
    {
        return array_values(array_filter(self::proposals(), fn ($p) => $p['job_id'] === $jobId));
    }

    public static function activeContractsForFreelancer(int $freelancerProfileId = 1): array
    {
        return array_values(array_filter(self::contracts(), fn ($c) => $c['freelancer_profile_id'] === $freelancerProfileId && $c['status'] === 'active'));
    }

    public static function pastContractsForFreelancer(int $freelancerProfileId = 1): array
    {
        return array_values(array_filter(self::contracts(), fn ($c) => $c['freelancer_profile_id'] === $freelancerProfileId && $c['status'] !== 'active'));
    }
}
