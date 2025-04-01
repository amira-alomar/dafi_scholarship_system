<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Graduates extends Model
{
    use HasFactory;

    protected $primaryKey = 'graduateID';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Graduate belongs to User
    }

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class, 'scholarship_id'); // Graduate belongs to Scholarship
    }
}

