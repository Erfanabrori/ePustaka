<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
        {
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('judul_buku');
            $table->string('sub_judul')->nullable();
            $table->string('isbn')->nullable();
            $table->integer('tahun_terbit')->nullable();
            $table->text('deskripsi')->nullable();
            $table->integer('jumlah_halaman')->nullable();
            $table->unsignedBigInteger('penerbit_id')->nullable();
            $table->string('tempat_terbit')->nullable();
            $table->string('edisi')->nullable();
            $table->string('nomor_panggil')->nullable();
            $table->integer('stok')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
