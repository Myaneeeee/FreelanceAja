<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'job_id',
        'proposal_id',
        'freelancer_profile_id',
        'client_profile_id',
        'final_price',
        'start_date',
        'end_date',
        'status',
    ];

    // relationships (job, proposal, freelancerProfile, clientProfile)
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
}
