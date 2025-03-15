<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationForm extends Model
{
    use HasFactory;

    protected $primaryKey = 'applicationFormID';
    protected $fillable = ['status', 'start_date', 'end_date'];

    public function questions()
    {
        return $this->hasMany(Question::class, 'idAppForm', 'applicationFormID');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'idForm', 'applicationFormID');
    }
}
