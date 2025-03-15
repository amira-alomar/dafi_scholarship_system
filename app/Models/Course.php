<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $primaryKey = 'courseID';
    protected $fillable = ['code', 'course_name', 'grade', 'semester', 'image', 'idUser', 'idUni'];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'id');
    }

    public function university()
    {
        return $this->belongsTo(University::class, 'idUni', 'universityID');
    }
}
