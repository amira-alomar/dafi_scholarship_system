<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;

    protected $primaryKey = 'scholarshipID';
    protected $fillable = ['name', 'funding_organization', 'start_date', 'end_date', 'description', 'idUni'];

    // Relationships
    public function university()
    {
        return $this->belongsTo(University::class, 'idUni'); // Each scholarship belongs to one university
    }
}

