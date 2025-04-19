<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $primaryKey = 'partnerID';
    protected $fillable = ['Partner_name', 'Partner_description', 'picture'];

    public function scholarships()
    {
        return $this->belongsToMany(Scholarship::class, 'shcolarship_partner', 'idPartner', 'idScholarship');
    }
}
