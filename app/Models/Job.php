<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'client_profile_id',
        'title',
        'description',
        'budget',
        'type',
        'status',
        'deadline',
    ];

    // TODO: relationships (clientProfile, skills, proposals, contract)
}
