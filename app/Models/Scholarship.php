<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;

    protected $primaryKey = 'scholarshipID';
    protected $fillable = ['name', 'funding_organization', 'start_date', 'end_date', 'description', 'idUni'];

    public function university()
    {
        return $this->belongsTo(University::class, 'idUni', 'universityID');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'idScholarship', 'scholarshipID');
    }

    public function criteria()
    {
        return $this->hasMany(Criteria::class, 'idScholarship', 'scholarshipID');
    }

    public function benefits()
    {
        return $this->hasMany(Benefit::class, 'idScholarship', 'scholarshipID');
    }

    public function partners()
    {
        return $this->belongsToMany(Partner::class, 'scholarship_partner', 'idScholarship', 'idPartner');
    }

    public function applicationStages()
    {
        return $this->hasMany(ApplicationStage::class, 'idScholarship', 'scholarshipID');
    }
}
