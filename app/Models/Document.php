<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'document_type_id',
        'title',
        'event_date',
        'notes',
        'file_path',
        'metadata', // Di V1 mungkin null, tapi tetap fillable
    ];

    /**
     * Tipe data casting.
     * 'event_date' akan otomatis menjadi objek Carbon (mudah diformat).
     * 'metadata' akan otomatis di-parse dari/ke JSON.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'event_date' => 'date',
        'metadata' => 'array',
    ];

    /**
     * Mendefinisikan relasi many-to-one ke model User.
     * Satu Dokumen dimiliki oleh satu User (pengunggah).
     */
    public function user()
    {
        // Parameter: (Nama Model yang dituju)
        return $this->belongsTo(User::class);
    }

    /**
     * Mendefinisikan relasi many-to-one ke model DocumentType.
     * Satu Dokumen memiliki satu Tipe Dokumen.
     */
    public function documentType()
    {
        // Parameter: (Nama Model yang dituju)
        return $this->belongsTo(DocumentType::class);
    }
}
