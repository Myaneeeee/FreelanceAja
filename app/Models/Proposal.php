<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $fillable = [
        'job_id',
        'freelancer_profile_id',
        'cover_letter',
        'bid_amount',
        'status',
    ];

    // relationships (job, freelancerProfile)
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function freelancerProfile()
    {
        return $this->belongsTo(FreelancerProfile::class);
    }
}
