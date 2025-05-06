<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedJob extends Model
{
    protected $fillable = [
        'user_id',
        'job_opportunity_id',
    ];
    
}
