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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');

            $table->unsignedBigInteger('id_kategori');
            $table->foreign('id_kategori')
                ->references('id')
                ->on('kategori_barangs')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->unsignedBigInteger('id_gudang');
            $table->foreign('id_gudang')
                ->references('id')
                ->on('gudangs')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->bigInteger('jumlah_stok')->default(0);
            $table->bigInteger('berat');
            $table->bigInteger('harga_jual');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
