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
        Schema::create('enlace_zonas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enlace_id')->constrained('enlaces')->onDelete('cascade');
            $table->foreignId('zona_id')->constrained('zonas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enlace_zonas');
    }
};
