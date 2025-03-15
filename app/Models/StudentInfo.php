<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInfo extends Model
{
    use HasFactory;

    protected $primaryKey = 'studentInfoID';
    protected $fillable = ['major', 'gpa', 'year', 'number_of_training', 'number_of_volunteering', 'image', 'idUser', 'idUni'];

    // Relationships
    public function user()
    {
        return $this->belongsTo(AllUser::class, 'idUser'); // Each student info belongs to one user
    }

    public function university()
    {
        return $this->belongsTo(University::class, 'idUni'); // Each student info belongs to one university
    }
}
