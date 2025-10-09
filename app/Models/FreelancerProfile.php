<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreelancerProfile extends Model
{
    protected $fillable = [
        'user_id',
        'headline',
        'bio',
        'portfolio_url',
        'rate_per_hour'
    ];

    // TODO: relationships (user, skills, proposals, contracts)
}
