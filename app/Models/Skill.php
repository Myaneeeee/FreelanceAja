<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    // use HasFactory;

    protected $fillable = ['name'];

    // Relationships
    public function freelancers()
    {
        return $this->belongsToMany(FreelancerProfile::class, 'freelancer_skills', 'skill_id', 'freelancer_profile_id');
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_skills', 'skill_id', 'job_id');
    }

    // Dummy data method
    public static function getDummyData($count = 5)
    {
        $dummySkills = [];
        for ($i = 1; $i <= $count; $i++) {
            $dummySkills[] = [
                'id' => $i,
                'name' => "Skill $i",
            ];
        }
        return $dummySkills;
    }
}
