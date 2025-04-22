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
        Schema::create('penerimaan_barangs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_asal_barang');
            $table->foreign('id_asal_barang')
                ->references('id')
                ->on('lokasis')
                ->cascadeOnUpdate();

            $table->unsignedBigInteger('id_tujuan_pengiriman');
            $table->foreign('id_tujuan_pengiriman')
                ->references('id')
                ->on('lokasis')
                ->cascadeOnUpdate();

            $table->dateTime('tanggal_penerimaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerimaan_barangs');
    }
};
