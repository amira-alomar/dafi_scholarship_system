<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInfo extends Model
{
    use HasFactory;

    protected $primaryKey = 'studentInfoID';
    protected $fillable = ['major','expected_graduation', 'gpa', 'year', 'number_of_training', 'number_of_volunteering', 'image', 'idUser', 'idUni'];

    public function user()
    {
        return $this->belongsTo(AllUser::class, 'idUser', 'id');
    }

    public function university()
    {
        return $this->belongsTo(University::class, 'idUni', 'universityID');
    }
    public function trainings()
{
    return $this->hasMany(Training::class, 'studentInfoID');
}
public function volunteerings()
{
    return $this->hasMany(volunteering::class, 'studentInfoID');
}
public function scholarship()
{
    return $this->belongsTo(Scholarship::class, 'idScholarship', 'scholarshipID');
}
public function academicGoals()
{
    return $this->hasMany(AcademicGoal::class, 'studentInfoID');
}



}
