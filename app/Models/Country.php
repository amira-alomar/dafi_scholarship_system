<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected $fillable = [
        'user_id',
        'graduation_year',
        'profile_picture',
        'feedback',
        'scholarship_id'
    ];

    public function scholarships()
{
    return $this->belongsToMany(Scholarship::class, 'scholarship_country');
}

}
