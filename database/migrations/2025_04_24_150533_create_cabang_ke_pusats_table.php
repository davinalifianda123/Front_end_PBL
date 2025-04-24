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
        Schema::create('cabang_ke_pusats', function (Blueprint $table) {
            $table->id();
            $table->string(column: 'kode');
            $table->unsignedBigInteger(column: 'id_pusat');
            $table->foreign('id_pusat')
                ->references('id')
                ->on('gudang_dan_tokos')
                ->cascadeOnUpdate();

            $table->unsignedBigInteger(column: 'id_cabang');
            $table->foreign('id_cabang')
                ->references('id')
                ->on('gudang_dan_tokos')
                ->cascadeOnUpdate();

            $table->unsignedBigInteger(column: 'id_barang');
            $table->foreign('id_barang')
                ->references('id')
                ->on('barangs')
                ->cascadeOnUpdate();

            $table->integer(column: 'jumlah');
            $table->dateTime(column: 'tanggal');

            $table->timestamps();
            $table->SoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cabang_ke_pusats');
    }
};
