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
        Schema::create('detail_penerimaan_barangs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_penerimaan_barang');
            $table->foreign('id_penerimaan_barang')
                ->references('id')
                ->on('penerimaan_barangs')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->unsignedBigInteger('id_barang')->nullable();
            $table->foreign('id_barang')
                ->references('id')
                ->on('barangs')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            
            $table->bigInteger('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penerimaan_barangs');
    }
};
