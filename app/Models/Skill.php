<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['name'];

    // TODO: relationships (freelancers many-to-many, jobs many-to-many)
}
