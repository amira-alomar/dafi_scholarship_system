<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $primaryKey = 'applicationID';
    protected $fillable = ['notes', 'status', 'submission_date', 'idUser', 'idScholarship', 'idForm', 'idInterview', 'idExam'];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'id');
    }

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class, 'idScholarship', 'scholarshipID');
    }

    public function applicationForm()
    {
        return $this->belongsTo(ApplicationForm::class, 'idForm', 'applicationFormID');
    }

    public function interview()
    {
        return $this->belongsTo(Interview::class, 'idInterview', 'interviewID');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'idExam', 'examID');
    }

    public function applicationStages()
    {
        return $this->belongsToMany(ApplicationStage::class, 'application_stage_progress', 'idApp', 'idAppStage');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'idApp', 'applicationID');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'idApp', 'applicationID');
    }
}
