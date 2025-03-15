<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'universityID';
    protected $fillable = ['name', 'location', 'website', 'contact_email', 'phone_number'];

    // Relationships
    
}
