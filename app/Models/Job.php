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

    // relationships (clientProfile, skills, proposals, contract)
    public function clientProfile()
    {
        return $this->belongsTo(ClientProfile::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_skill');
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }
}
