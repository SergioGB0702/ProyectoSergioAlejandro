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
        Schema::create('incidencia_correccionaplicadas', function (Blueprint $table) {
            $table->unsignedBigInteger('incidencia_id');
            $table->unsignedBigInteger('correccionaplicadas_id');
            $table->foreign('incidencia_id')->references('id')->on('incidencias');
            $table->foreign('correccionaplicadas_id')->references('id')->on('correccionaplicadas');
            $table->primary(['incidencia_id', 'correccionaplicadas_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencia_correccionaplicadas');
    }
};
