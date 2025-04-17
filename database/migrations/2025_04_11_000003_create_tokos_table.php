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
        Schema::create('tokos', function (Blueprint $table) {
            $table->id();
            $table->string('nama_toko');

            $table->unsignedBigInteger('id_jenis_toko');
            $table->foreign('id_jenis_toko')
                ->references('id')
                ->on('jenis_tokos')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->string('alamat');
            $table->string('no_telepon');
            $table->integer('flag')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokos');
    }
};
