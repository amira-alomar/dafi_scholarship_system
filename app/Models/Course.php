<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $primaryKey = 'courseID';
   protected $fillable = [
    'semester',
    'course_name',
    'code',
    'grade',
    'credit',
    'image',
    'idUser',
    'idUni',
];
    public $incrementing = true; // أو false لو مش incrementing
    protected $keyType = 'int';  // أو 'string' لو المفتاح نصي


    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'id');
    }

    public function university()
    {
        return $this->belongsTo(University::class, 'idUni', 'universityID');
    }
    public function getRouteKeyName()
{
    return 'courseID';
}

}
