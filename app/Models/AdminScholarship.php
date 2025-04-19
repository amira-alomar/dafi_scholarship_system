<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminScholarship extends Model
{
    use HasFactory;

    protected $table = 'admin_scholarships';

    protected $fillable = ['admin_id', 'scholarship_id'];


    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class, 'scholarship_id');
    }
}
