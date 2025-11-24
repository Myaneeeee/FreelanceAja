<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientProfile extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'company_description',
        'website_url'
    ];

    // relationships (user, jobs, contracts)
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
}
