<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationStage extends Model
{
    use HasFactory;

    protected $primaryKey = 'applicationStageID';
    protected $fillable = ['name', 'order', 'idScholarship'];

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class, 'idScholarship', 'scholarshipID');
    }

    public function applications()
    {
        return $this->belongsToMany(Application::class, 'application_stage_progress', 'idAppStage', 'idApp');
    }
}
