<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_layanan');
            $table->integer('harga_per_kg');
            $table->string('estimasi_waktu');
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('layanans');
    }
};
