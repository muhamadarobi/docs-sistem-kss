<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Mendefinisikan relasi one-to-many ke model Document.
     * Satu Tipe Dokumen bisa memiliki banyak Dokumen.
     */
    public function documents()
    {
        // Parameter: (Nama Model yang dituju)
        return $this->hasMany(Document::class);
    }
}
