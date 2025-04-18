<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'phone', 'address', 'role'];
    
    public function scholarships()
{
    return $this->belongsToMany(Scholarship::class, 'admin_scholarships', 'admin_id', 'idScholarship', 'id', 'scholarshipID');


}

    

}
