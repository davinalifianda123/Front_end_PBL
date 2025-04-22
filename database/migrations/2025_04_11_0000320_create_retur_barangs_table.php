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
        Schema::create('retur_barangs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_penanggung_jawab');
            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            
            $table->dateTime('tanggal_retur');
            $table->text('alasan_retur');

            $table->unsignedBigInteger('id_status_retur')->default(1);
            $table->foreign('id_status_retur')
                ->references('id')
                ->on('status_returs')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->unsignedBigInteger('id_pengiriman_barang');
            $table->foreign('id_pengiriman_barang')
                ->references('id')
                ->on('pengiriman_barangs')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->integer('flag')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retur_barangs');
    }
};
