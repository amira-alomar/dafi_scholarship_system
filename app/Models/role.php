<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    public function users()
    {
        return $this->hasMany(AllUser::class, 'idRole'); // One role has many users
    }
}
