<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    protected $primaryKey = 'criteriaID';
    protected $fillable = ['criteria_text', 'idScholarship'];

    // Relationships
    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class, 'idScholarship'); // Each criteria belongs to a scholarship
    }
}

