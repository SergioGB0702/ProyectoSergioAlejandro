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
        Schema::create('partes', function (Blueprint $table) {
            $table->id();
            $table->string("alumno_dni");
            $table->string("profesor_dni");
            $table->string("colectivo");
            $table->longText("descripcion_detallada")->nullable();
            $table->foreignId("tramo_horario_id");
            $table->foreign('alumno_dni')->references('dni')->on('alumnos');
            $table->foreign('profesor_dni')->references('dni')->on('profesors');
            $table->foreign('tramo_horario_id')->references('id')->on('tramohorarios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partes');
    }
};
