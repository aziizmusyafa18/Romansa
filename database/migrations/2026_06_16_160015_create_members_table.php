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
        Schema::create('members', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('nama');
            $table->year('tahun_masuk');
            $table->year('lulus_madrasah')->nullable();
            $table->string('kampus')->nullable();
            $table->string('wali')->nullable();
            $table->string('job')->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
