<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    use HasFactory;

    protected $primaryKey = 'opportunityID';
    protected $fillable = ['title', 'date', 'description', 'location', 'type', 'status', 'idUser'];

    public function scholarships()
    {
        return $this->belongsToMany(Scholarship::class, 'opportunity_scholarship', 'opportunityID', 'scholarshipID');
    }
    
}
