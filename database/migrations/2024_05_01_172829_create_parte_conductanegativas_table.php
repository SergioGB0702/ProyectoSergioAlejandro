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
        Schema::create('parte_conductanegativas', function (Blueprint $table) {
            $table->unsignedBigInteger('parte_id');
            $table->unsignedBigInteger('conductanegativas_id');
            $table->foreign('parte_id')->references('id')->on('partes');
            $table->foreign('conductanegativas_id')->references('id')->on('conductanegativas');
            $table->primary(['parte_id', 'conductanegativas_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parte_conductanegativas');
    }
};
