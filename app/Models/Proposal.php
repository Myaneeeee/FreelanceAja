<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    // use HasFactory;

    protected $fillable = [
        'job_id', 'freelancer_profile_id', 'cover_letter', 'bid_amount', 'status',
    ];

    // Relationships
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function freelancerProfile()
    {
        return $this->belongsTo(FreelancerProfile::class);
    }

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }

    // Dummy data method
    public static function getDummyData($count = 5)
    {
        $dummyProposals = [];
        for ($i = 1; $i <= $count; $i++) {
            $dummyProposals[] = [
                'id' => $i,
                'job_id' => $i,
                'freelancer_profile_id' => $i,
                'cover_letter' => "Cover letter for proposal $i...",
                'bid_amount' => 800.00 + ($i * 50),
                'status' => 'sent',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        return $dummyProposals;
    }
}
