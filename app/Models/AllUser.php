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
}
