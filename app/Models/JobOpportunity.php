<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOpportunity extends Model
{
    use HasFactory;

    protected $primaryKey = 'jobID';
    protected $fillable = ['title', 'company_name', 'location', 'description', 'application_deadline'];

    // Relationships
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_skills', 'idJob_Opportunity', 'idSkill');
    }
}

