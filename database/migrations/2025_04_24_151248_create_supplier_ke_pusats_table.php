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
        Schema::create('supplier_ke_pusats', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string(column: 'kode');
            $table->unsignedBigInteger('id_supplier');
            $table->foreign('id_supplier')
                ->references('id')
                ->on('gudang_dan_tokos')
                ->cascadeOnUpdate();
            
            $table->unsignedBigInteger('id_pusat');
            $table->foreign('id_pusat')
                    ->references('id')
                    ->on('gudang_dan_tokos')
                    ->cascadeOnUpdate();
            
            $table->unsignedBigInteger('id_barang');
            $table->foreign('id_barang')
                    ->references('id')
                    ->on('barangs')
                    ->cascadeOnUpdate();

            $table->integer('jumlah');
            $table->dateTime('tanggal');
            $table-> integer(column: 'flag')->default(value: 1);
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_ke_pusats');
    }
};
