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
        Schema::create('pusat_ke_suppliers', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('kode'); // Kolom wajib
            $table->unsignedBigInteger('id_supplier'); // Foreign Key
            $table->unsignedBigInteger('id_pusat'); // Foreign Key
            $table->unsignedBigInteger('id_barang'); // Foreign Key
            $table->bigInteger('jumlah'); // Kolom wajib
            $table->datetime('tanggal'); // Kolom wajib
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('id_supplier')->references('id')->on('gudang_dan_tokos')->cascadeOnUpdate();
            $table->foreign('id_pusat')->references('id')->on('gudang_dan_tokos')->cascadeOnUpdate();
            $table->foreign('id_barang')->references('id')->on('barangs')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pusat_ke_suppliers');
    }
};
