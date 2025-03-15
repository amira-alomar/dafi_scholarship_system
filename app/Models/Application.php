<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $primaryKey = 'applicationID';
    protected $fillable = ['notes', 'status', 'submission_date', 'idUser', 'idScholarship', 'idForm', 'idInterview', 'idExam'];

    // Relationships
    public function user()
    {
        return $this->belongsTo(AllUser::class, 'idUser'); // Each application belongs to one user
    }

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class, 'idScholarship'); // Each application is for one scholarship
    }

    public function form()
    {
        return $this->belongsTo(ApplicationForm::class, 'idForm'); // Each application is linked to one application form
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'idExam'); // Each application may have one exam
    }
}

