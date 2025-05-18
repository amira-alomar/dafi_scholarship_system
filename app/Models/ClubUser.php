<?php

// app/Models/ClubUser.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClubUser extends Model
{
    protected $table = 'club_user'; // لأن الجدول pivot مو convention الافتراضي
    protected $fillable = ['idUser', 'club_id', 'status'];
    
    public function user()
    {
        return $this->belongsTo(AllUser::class, 'idUser');
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
