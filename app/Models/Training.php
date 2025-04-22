<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'certificate', 'student_info_id'];

    public function studentInfo()
    {
        return $this->belongsTo(StudentInfo::class);
    }
}

