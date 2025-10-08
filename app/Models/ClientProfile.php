<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientProfile extends Model
{
    // use HasFactory;

    protected $fillable = [
        'user_id', 'company_name', 'company_description', 'website_url',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
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
                'company_name' => "Company $i",
                'company_description' => "Description for company $i...",
                'website_url' => "https://company$i.com",
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        return $dummyProfiles;
    }
}
