<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $primaryKey = 'skillID';
    protected $fillable = ['name', 'idUser'];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'id');
    }

    public function jobSkills()
    {
        return $this->hasMany(JobSkills::class, 'idSkill', 'skillID');
    }
}
