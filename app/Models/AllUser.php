<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Graduates;

class AllUser  extends Authenticatable
{
    protected $fillable = [
        'lname', 'fname',  'birthdate','phone_number','profile_picture','email', 'address', 'password', 'role_id','status'
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
    public function graduates()
    {
        return $this->hasMany(Graduates::class, 'user_id'); // User has many Graduates
    }
   public function skills()
{
    return $this->belongsToMany(Skill::class, 'user_skills', 'idUser', 'idSkill');
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

    // public function opportunities()
    // {
    //     return $this->hasMany(Opportunity::class, 'idUser', 'id');
    // }

    public function userSkills()
    {
        return $this->hasMany(UserSkills::class, 'idUser', 'id');
    }

    public function userOpportunities()
    {
        return $this->hasMany(UserOpportunity::class, 'idUser', 'id');
    }
  
   
}
