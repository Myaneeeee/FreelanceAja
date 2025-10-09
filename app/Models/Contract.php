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

    // TODO: relationships (job, proposal, freelancerProfile, clientProfile)
}
