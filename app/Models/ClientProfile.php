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

    // TODO: relationships (user, jobs, contracts)
}
