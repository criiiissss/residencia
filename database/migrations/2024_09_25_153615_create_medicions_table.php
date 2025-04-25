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
        Schema::create('medicions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idPuntaA')->references('id')->on('ubicacions');
            $table->unsignedBigInteger('idPuntaB')->references('id')->on('ubicacions');
            $table->unsignedBigInteger('idLinea')->references('id')->on('enlaces');
            $table->decimal('atenuacionReal',20,10)->nullable();
            $table->date('fecha')->nullable();
            $table->string('ubicacionPDF');
            $table->string('ubicacionXLS');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicions');
    }
};
