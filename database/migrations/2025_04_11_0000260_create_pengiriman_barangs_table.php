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
        Schema::create('pengiriman_barangs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_gudang')->nullable();
            $table->foreign('id_gudang')
                ->references('id')
                ->on('gudangs')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->dateTime('tanggal_pengiriman');

            $table->unsignedBigInteger('id_kurir')->nullable();
            $table->foreign('id_kurir')
                ->references('id')
                ->on('kurirs')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->unsignedBigInteger('id_toko')->nullable();
            $table->foreign('id_toko')
                ->references('id')
                ->on('tokos')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->unsignedBigInteger('id_status_pengiriman')->nullable();
            $table->foreign('id_status_pengiriman')
                ->references('id')
                ->on('status_pengiriman_barangs')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengiriman_barangs');
    }
};
