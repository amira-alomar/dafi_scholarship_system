<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $primaryKey = 'interviewID';
    protected $fillable = [
        'interview_date',
        'performance_level',
        'recommendation',
        'notes',
    ];

    public function application()
    {
        return $this->hasOne(Application::class, 'idInterview', 'interviewID');
    }
}
