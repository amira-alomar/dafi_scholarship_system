<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationStageProgress extends Model
{
    use HasFactory;

    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = ['idApp', 'idAppStage'];

    // Relationships
    public function application()
    {
        return $this->belongsTo(Application::class, 'idApp'); // Each progress entry belongs to one application
    }

    public function stage()
    {
        return $this->belongsTo(ApplicationStage::class, 'idAppStage'); // Each progress entry belongs to one stage
    }
}

