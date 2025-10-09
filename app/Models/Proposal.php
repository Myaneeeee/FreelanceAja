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

    // TODO: relationships (job, freelancerProfile)
}
