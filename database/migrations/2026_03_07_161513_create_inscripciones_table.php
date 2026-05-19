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
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('rodada_id');
            $table->enum('estado', ['inscrito', 'no_inscrito'])->default('no_inscrito');
            $table->date('fecha');
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('usuarios')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('rodada_id')->references('id')->on('rodadas')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripciones');
    }
};
