<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequiredDocument extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'idScholarship'];
    public function documents()
    {
        return $this->hasMany(Document::class, 'required_document_id', 'id');
    }

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class, 'idScholarship');
    }
}
