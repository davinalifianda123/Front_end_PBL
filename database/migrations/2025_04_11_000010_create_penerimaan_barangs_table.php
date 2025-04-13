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

            $table->unsignedBigInteger('id_supplier');
            $table->foreign('id_supplier')
                ->references('id')
                ->on('suppliers');

            $table->unsignedBigInteger('id_gudang');
            $table->foreign('id_gudang')
                ->references('id')
                ->on('gudangs');

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
