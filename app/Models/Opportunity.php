<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    use HasFactory;

    protected $primaryKey = 'opportunityID';
    protected $fillable = ['title', 'date', 'description', 'location', 'type', 'status', 'idUser'];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'id');
    }
}
