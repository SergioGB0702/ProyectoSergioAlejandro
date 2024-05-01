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
        Schema::create('incidencia_conductanegativas', function (Blueprint $table) {
            $table->unsignedBigInteger('incidencia_id');
            $table->unsignedBigInteger('conductanegativas_id');
            $table->foreign('incidencia_id')->references('id')->on('incidencias');
            $table->foreign('conductanegativas_id')->references('id')->on('conductanegativas');
            $table->primary(['incidencia_id', 'conductanegativas_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencia_conductanegativas');
    }
};