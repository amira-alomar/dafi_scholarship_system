<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicGoal extends Model
{
    use HasFactory;

    protected $primaryKey = 'goalID';

    protected $fillable = [
        'studentInfoID',
        'title',
        'description',
        'due_date',
        'progress',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];
    

    public function studentInfo()
    {
        return $this->belongsTo(StudentInfo::class, 'studentInfoID');
    }

    public function getDaysRemainingAttribute()
    {
        return  (int) now()->diffInDays($this->due_date, false);
    }

    public function getCompletionColorAttribute()
    {
        if ($this->progress >= 80) return 'green';
        if ($this->progress <= 30) return 'red';
        return 'orange';
    }
}

