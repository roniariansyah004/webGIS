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
        Schema::create('umkms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatan_id')->constrained('kecamatans')->cascadeOnDelete();
            $table->foreignId('kategori_id')->constrained('kategoris')->cascadeOnDelete();
            $table->string('nama_umkm', 150);
            $table->string('nama_pemilik', 100)->nullable();
            $table->string('no_telepon', 30)->nullable();
            $table->text('alamat')->nullable();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('foto')->nullable();
            $table->text('deskripsi')->nullable();
            $table->integer('tahun_berdiri')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};
