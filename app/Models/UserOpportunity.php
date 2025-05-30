<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOpportunity extends Model
{
    use HasFactory;

    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = ['idUser', 'idOpportunity',  'application_date','status'];

    // Relationships
    public function user()
    {
        return $this->belongsTo(AllUser::class, 'idUser', 'id');
    }

    public function opportunity()
{
    return $this->belongsTo(Opportunity::class, 'idOpportunity');
}

}

