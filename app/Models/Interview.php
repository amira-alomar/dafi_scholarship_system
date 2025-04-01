<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $primaryKey = 'interviewID';
    protected $fillable = ['interview_date', 'status', 'interview_result'];

    public function application()
    {
        return $this->hasOne(Application::class, 'idInterview', 'interviewID');
    }
}
