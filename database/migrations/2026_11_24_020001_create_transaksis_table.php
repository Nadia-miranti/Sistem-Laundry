<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layanan_id')->constrained('layanans')->onDelete('cascade');
            $table->string('nama_pelanggan');
            $table->string('no_hp');
            $table->decimal('berat', 8, 2);
            $table->integer('total_harga');
            $table->enum('status', ['Proses', 'Selesai'])->default('Proses');
            $table->enum('status_bayar', ['Belum Lunas', 'Lunas'])->default('Belum Lunas');
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('transaksis');
    }
};
