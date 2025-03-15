<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSkills extends Model
{
    use HasFactory;

    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = ['idSkill', 'idJob_Opportunity'];

    // Relationships
    public function skill()
    {
        return $this->belongsTo(Skill::class, 'idSkill'); // Each job skill record is linked to a skill
    }

    public function jobOpportunity()
    {
        return $this->belongsTo(JobOpportunity::class, 'idJob_Opportunity'); // Each job skill record is linked to a job opportunity
    }
}

