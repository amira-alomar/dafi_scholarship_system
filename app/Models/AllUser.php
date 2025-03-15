<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class AllUser  extends Authenticatable
{
    protected $fillable = [
        'lname', 'fname', 'phone_number', 'email', 'address', 'password', 'role_id'
    ];
    protected $table = 'all_users';
    protected $guarded = [];

    protected $hidden = [
        'password',
    ];
    protected $with = ['role'];
    
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function skills()
    {
        return $this->hasMany(Skill::class, 'idUser', 'id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'idUser', 'id');
    }

    public function studentInfo()
    {
        return $this->hasOne(StudentInfo::class, 'idUser', 'id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'idUser', 'id');
    }

    public function opportunities()
    {
        return $this->hasMany(Opportunity::class, 'idUser', 'id');
    }

    public function userSkills()
    {
        return $this->hasMany(Skill::class, 'idUser', 'id');
    }

    public function userOpportunities()
    {
        return $this->hasMany(UserOpportunity::class, 'idUser', 'id');
    }
}
