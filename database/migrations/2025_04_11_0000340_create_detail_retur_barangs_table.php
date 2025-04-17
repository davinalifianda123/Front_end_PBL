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
        Schema::create('detail_retur_barangs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_retur');
            $table->foreign('id_retur')
                ->references('id')
                ->on('retur_barangs')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            
            $table->unsignedBigInteger('id_barang');
            $table->foreign('id_barang')
                ->references('id')
                ->on('barangs')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            
            $table->bigInteger('jumlah_barang_retur');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_retur_barangs');
    }
};
