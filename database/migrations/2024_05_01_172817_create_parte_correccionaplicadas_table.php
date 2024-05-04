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
        Schema::create('parte_correccionaplicadas', function (Blueprint $table) {
            $table->unsignedBigInteger('parte_id');
            $table->unsignedBigInteger('correccionaplicadas_id');
            $table->foreign('parte_id')->references('id')->on('partes');
            $table->foreign('correccionaplicadas_id')->references('id')->on('correccionaplicadas');
            $table->primary(['parte_id', 'correccionaplicadas_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parte_correccionaplicadas');
    }
};
