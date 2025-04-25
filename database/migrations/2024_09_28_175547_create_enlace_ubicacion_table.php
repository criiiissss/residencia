<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnlaceUbicacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enlace_ubicacions', function (Blueprint $table) {
            $table->id();
            $table->string('punta')->nullable();
            $table->foreignId('enlace_id')->constrained('enlaces')->onDelete('cascade');
            $table->foreignId('ubicacion_id')->constrained('ubicacions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enlace_ubicacion');
    }
}
