<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            // Diubah menjadi opsional (boleh NULL)
            $table->string('email')->unique()->nullable();

            // Kolom email_verified_at DIHAPUS
            // $table->timestamp('email_verified_at')->nullable();

            $table->string('password');

            // Kolom remember_token DIKEMBALIKAN (sesuai permintaan)
            $table->rememberToken();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
