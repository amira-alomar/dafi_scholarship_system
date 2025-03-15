<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    protected $primaryKey = 'universityID';
    protected $fillable = ['name', 'location', 'website', 'contact_email', 'phone_number'];

    public function scholarships()
    {
        return $this->hasMany(Scholarship::class, 'idUni', 'universityID');
    }

    public function students()
    {
        return $this->hasMany(StudentInfo::class, 'idUni', 'universityID');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'idUni', 'universityID');
    }
}
