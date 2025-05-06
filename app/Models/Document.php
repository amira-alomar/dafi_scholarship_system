<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RequiredDocument;

class Document extends Model
{
    use HasFactory;

    protected $primaryKey = 'documentID';
    protected $fillable = ['document_path', 'document_type', 'document_name', 'idApp'];

    // Relationships
    public function application()
    {
        return $this->belongsTo(Application::class, 'idApp'); // Each document belongs to one application
    }
    public function requiredDocument()
    {
        return $this->belongsTo(RequiredDocument::class);
    }
}
