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
        Schema::create('enlaces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('tipo',['400KV','230KV','115KV','13.8KV','Subterraneo'])->default('400KV');
            $table->decimal('km',12,5)->nullable();
            $table->decimal('atenuacionKm',20,10)->nullable();
            $table->Integer('conectores')->nullable();
            $table->decimal('atenuacionConectores',20,10)->nullable();
            $table->decimal('atenuacionIdeal',20,10)->nullable();
            $table->Integer('cajasEmpalme')->nullable();
            $table->decimal('atenuacionCajas',20,10)->nullable();
            $table->unsignedBigInteger('idMedicionUltima')->reference('id')->on('medicions')->nullable();
            $table->Integer('noFibras');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enlaces');
    }
};
