<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    use HasFactory;

    protected $primaryKey = 'benefitID';
    protected $fillable = ['Benefit_text', 'idScholarship'];

    // Relationships
    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class, 'idScholarship'); // Each benefit belongs to a scholarship
    }
}

