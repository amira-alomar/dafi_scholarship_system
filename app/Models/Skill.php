<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $primaryKey = 'skillID';
    protected $fillable = ['name', 'idUser'];

    // Relationships
    public function user()
    {
        return $this->belongsTo(AllUser::class, 'id'); // Each skill belongs to one user
    }

    public function jobOpportunities()
    {
        return $this->belongsToMany(JobOpportunity::class, 'job_skills', 'idSkill', 'idJob_Opportunity');
    }
}

