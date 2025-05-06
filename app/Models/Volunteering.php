<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteering extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'total_hours',
        'certificate',
        'studentInfoID',
    ];

    public function studentInfo()
    {
        return $this->belongsTo(StudentInfo::class, 'studentInfoID');
    }
}

