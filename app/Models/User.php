<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'profile_picture_url', 'phone_number', 'city', 'province',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function freelancerProfile()
    {
        return $this->hasOne(FreelancerProfile::class);
    }

    public function clientProfile()
    {
        return $this->hasOne(ClientProfile::class);
    }

    public static function getDummyData($count = 5)
    {
        $dummyUsers = [];
        for ($i = 1; $i <= $count; $i++) {
            $dummyUsers[] = [
                'id' => $i,
                'name' => "User $i",
                'email' => "user$i@example.com",
                'role' => ($i % 2 === 0) ? 'freelancer' : 'client',
                'profile_picture_url' => "https://res.cloudinary.com/dqvlnzw9f/image/upload/v1745295739/VorteKia/ride_image/dfaw2slxvderxetfjyyq.jpg",
                'phone_number' => "123-456-789$i",
                'city' => "City $i",
                'province' => "Province $i",
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        return $dummyUsers;
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
