<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $primaryKey = 'examID';
    protected $fillable = ['score', 'status', 'exam_date', 'course'];

    public function application()
    {
        return $this->hasOne(Application::class, 'idExam', 'examID');
    }
}
