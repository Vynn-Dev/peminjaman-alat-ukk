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
        Schema::create('pengembalians', function (Blueprint $table) {

    $table->id();

    $table->foreignId('peminjaman_id')
          ->constrained('peminjamen')
          ->onDelete('cascade');

    $table->date('tanggal_pengembalian');

    $table->enum('kondisi_setelah_kembali', [
        'baik',
        'rusak ringan',
        'rusak berat'
    ]);

    $table->text('catatan')->nullable();

    $table->decimal('denda', 10, 2)->default(0);

    $table->enum('status', [
        'selesai',
        'belum selesai'
    ])->default('belum selesai');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
