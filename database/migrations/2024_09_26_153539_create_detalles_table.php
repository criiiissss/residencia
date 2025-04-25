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
        Schema::create('detalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idMedicions')->references('id')->on('medicions');
            $table->Integer('noFibra');
            $table->enum('estado',['Disponible','Ocupado'])->default('Disponible');
            $table->decimal('medicion',20,10);
            $table->string('comentario');
            $table->string('ubicacionXOR')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles');
    }
};
