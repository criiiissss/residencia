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
        Schema::create('estructuras', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('lat',20,15);
            $table->decimal('lng',20,15);
            $table->enum('cajaEmpalme',['si','no'])->default('no');
            $table->decimal('distancia',12,5);
            $table->unsignedBigInteger('idEnlace')->references('id')->on('enlaces');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estructuras');
    }
};
