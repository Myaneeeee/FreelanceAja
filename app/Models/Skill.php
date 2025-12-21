<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['name', 'is_global'];

    // relationships (freelancers many-to-many, jobs many-to-many)
    public function freelancerProfiles()
    {
        return $this->belongsToMany(FreelancerProfile::class, 'freelancer_profile_skill');
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_skill');
    }
}
