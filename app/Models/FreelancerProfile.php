<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreelancerProfile extends Model
{
    // use HasFactory;

    protected $fillable = [
        'user_id', 'headline', 'bio', 'portfolio_url', 'rate_per_hour',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'freelancer_skills', 'freelancer_profile_id', 'skill_id');
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    // Dummy data method
    public static function getDummyData($count = 5)
    {
        $dummyProfiles = [];
        for ($i = 1; $i <= $count; $i++) {
            $dummyProfiles[] = [
                'id' => $i,
                'user_id' => $i,
                'headline' => "Freelancer Headline $i",
                'bio' => "Bio for freelancer $i...",
                'portfolio_url' => "https://portfolio$i.com",
                'rate_per_hour' => 50.00 + $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        return $dummyProfiles;
    }
}
