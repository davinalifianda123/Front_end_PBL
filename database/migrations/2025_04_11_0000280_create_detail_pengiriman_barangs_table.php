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
        Schema::create('detail_pengiriman_barangs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_barang')->nullable();
            $table->foreign('id_barang')
                ->references('id')
                ->on('barangs')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->unsignedBigInteger('id_pengiriman_barang');
            $table->foreign('id_pengiriman_barang')
                ->references('id')
                ->on('pengiriman_barangs')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->bigInteger('jumlah');
            $table->integer('flag')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pengiriman_barangs');
    }
};
