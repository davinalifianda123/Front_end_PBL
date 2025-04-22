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
        Schema::create('lokasis', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_gudang')->nullable();
            $table->foreign('id_gudang')
                ->references('id')
                ->on('gudangs')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->unsignedBigInteger('id_toko')->nullable();
            $table->foreign('id_toko')
                ->references('id')
                ->on('tokos')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

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
        Schema::dropIfExists('lokasis');
    }
};
