<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal.
     * (DIUBAH) Disesuaikan dengan migrasi baru
     */
    protected $fillable = [
        'user_id',
        'document_type_id', // Diubah dari document_type
        'title',            // Baru
        'event_date',       // Baru
        'notes',            // Diubah dari description
        'file_path',
        'metadata',         // Baru
    ];

    /**
     * Relasi ke User (pemilik dokumen).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * (BARU) Relasi ke DocumentType.
     */
    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }
}
