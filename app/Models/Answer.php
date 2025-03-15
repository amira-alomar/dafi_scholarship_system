<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $primaryKey = 'answerID';
    protected $fillable = ['answer_text', 'score', 'idQuestion', 'idApp'];

    // Relationships
    public function question()
    {
        return $this->belongsTo(Question::class, 'idQuestion'); // Each answer belongs to one question
    }

    public function application()
    {
        return $this->belongsTo(Application::class, 'idApp'); // Each answer is part of one application
    }
}

