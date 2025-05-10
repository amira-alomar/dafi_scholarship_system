<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSkills extends Model
{
    use HasFactory;

   
    public $incrementing = false;
    protected $fillable = ['idUser', 'idSkill', 'level'];
    protected $table = 'user_skills';
    // Relationships
    public function user()
    {
        return $this->belongsTo(AllUser::class, 'idUser', 'id');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'idSkill', 'skillID');
    }
}

