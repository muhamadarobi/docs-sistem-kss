<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
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
     * Mendefinisikan relasi one-to-many ke model User.
     * Satu Role (peran) bisa dimiliki oleh banyak User.
     */
    public function users()
    {
        // Parameter: (Nama Model yang dituju)
        return $this->hasMany(User::class);
    }
}
