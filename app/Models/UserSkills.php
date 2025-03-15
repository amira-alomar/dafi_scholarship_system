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
        return $this->belongsTo(User::class, 'idUser', 'id');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'idSkill', 'skillID');
    }
}

