<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationForm extends Model
{
    use HasFactory;

    protected $primaryKey = 'applicationFormID';
    protected $fillable = ['status'];


    public function applications()
    {
        return $this->hasMany(Application::class, 'idForm', 'applicationFormID');
    }
}
