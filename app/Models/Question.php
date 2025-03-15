<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $primaryKey = 'questionID';
    protected $fillable = ['question_text', 'idAppForm', 'idScholarship'];

    // Relationships
    public function applicationForm()
    {
        return $this->belongsTo(ApplicationForm::class, 'idAppForm'); // Each question belongs to one application form
    }

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class, 'idScholarship'); // Each question is linked to one scholarship
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'idQuestion', 'questionID');
    }
}
