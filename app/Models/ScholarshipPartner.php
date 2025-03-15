<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarshipPartner extends Model
{
    use HasFactory;

    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = ['idScholarship', 'idPartner'];

    // Relationships
    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class, 'idScholarship'); // Each scholarship partner record links to a scholarship
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'idPartner'); // Each scholarship partner record links to a partner
    }
}
