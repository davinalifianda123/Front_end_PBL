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

            $table->unsignedBigInteger('id_parent_barang')->nullable();
            $table->foreign('id_parent_barang')
                ->references('id')
                ->on('barangs')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            
            $table->unsignedBigInteger('id_gudang')->nullable();
            $table->foreign('id_gudang')
                ->references('id')
                ->on('gudangs')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
                
            $table->unsignedBigInteger('id_toko')->nullable();
            $table->foreign('id_toko')
                ->references('id')
                ->on('tokos')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->bigInteger('jumlah_stok')->default(0);
            $table->bigInteger('berat');
            $table->integer('flag')->default(1);

            $table->timestamps();
            $table->softDeletes();
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
