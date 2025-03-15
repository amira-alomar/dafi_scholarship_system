<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSkills extends Model
{
    use HasFactory;

    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = ['idUser', 'idSkill', 'level'];

    // Relationships
    public function user()
    {
        return $this->belongsTo(AllUser::class, 'id'); // Each user skill is linked to a user
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'idSkill'); // Each user skill is linked to a skill
    }
}

