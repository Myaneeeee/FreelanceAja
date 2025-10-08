<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    // use HasFactory;

    protected $fillable = [
        'job_id', 'proposal_id', 'freelancer_profile_id', 'client_profile_id', 'final_price', 'start_date', 'end_date', 'status',
    ];

    // Relationships
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    public function freelancerProfile()
    {
        return $this->belongsTo(FreelancerProfile::class);
    }

    public function clientProfile()
    {
        return $this->belongsTo(ClientProfile::class);
    }

    // Dummy data method
    public static function getDummyData($count = 5)
    {
        $dummyContracts = [];
        for ($i = 1; $i <= $count; $i++) {
            $dummyContracts[] = [
                'id' => $i,
                'job_id' => $i,
                'proposal_id' => $i,
                'freelancer_profile_id' => $i,
                'client_profile_id' => $i,
                'final_price' => 900.00 + ($i * 100),
                'start_date' => now(),
                'end_date' => now()->addDays(60),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        return $dummyContracts;
    }
}
