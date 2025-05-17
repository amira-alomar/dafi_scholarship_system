<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Club extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'image',
    ];

    public function users()
    {
        return $this->belongsToMany(AllUser::class, 'club_user', 'club_id', 'idUser')->withPivot('status')->withTimestamps();
    }

}
