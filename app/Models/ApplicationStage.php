<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationStage extends Model
{
    use HasFactory;

    protected $primaryKey = 'applicationStageID';
    protected $fillable = ['name', 'order', 'idScholarship'];

    // Relationships
    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class, 'idScholarship'); // Each stage belongs to one scholarship
    }
}
