<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    // use HasFactory;

    protected $fillable = [
        'client_profile_id', 'title', 'description', 'budget', 'type', 'status', 'deadline',
    ];

    // Relationships
    public function clientProfile()
    {
        return $this->belongsTo(ClientProfile::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_skills', 'job_id', 'skill_id');
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }

    // Dummy data method
    public static function getDummyData($count = 5)
    {
        $dummyJobs = [];
        for ($i = 1; $i <= $count; $i++) {
            $dummyJobs[] = [
                'id' => $i,
                'client_profile_id' => $i,
                'title' => "Job Title $i",
                'description' => "Description for job $i...",
                'budget' => 1000.00 + ($i * 100),
                'type' => ($i % 2 === 0) ? 'fixed_price' : 'hourly',
                'status' => 'open',
                'deadline' => now()->addDays(30),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        return $dummyJobs;
    }
}
