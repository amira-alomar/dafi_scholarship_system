<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $primaryKey = 'skillID';
    protected $fillable = ['name'];


    public function jobSkills()
    {
        return $this->hasMany(JobSkills::class, 'idSkill', 'skillID');
    }
    public function UserSkills()
    {
        return $this->hasMany(JobSkills::class, 'idSkill', 'skillID');
    }
}
