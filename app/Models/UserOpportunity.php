<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOpportunity extends Model
{
    use HasFactory;

    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = ['idUser', 'idOpportunity'];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'id');
    }

    public function jobOpportunity()
    {
        return $this->belongsTo(JobOpportunity::class, 'idOpportunity'); // Each user opportunity is linked to a job opportunity
    }
}

