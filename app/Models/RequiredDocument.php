<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequiredDocument extends Model
{
public function documents()
{
    return $this->hasMany(Document::class, 'required_document_id', 'id');
}

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class, 'idScholarship');
    }
}
