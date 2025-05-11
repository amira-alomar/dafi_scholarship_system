<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOpportunity extends Model
{
    use HasFactory;

    protected $primaryKey = 'jobID';
    protected $fillable = ['title', 'company_name', 'location', 'details','description', 'application_method', 'application_deadline','posting_date'];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_skills', 'idJob_Opportunity', 'idSkill');
    }
}
