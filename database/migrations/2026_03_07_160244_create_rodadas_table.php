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
        Schema::create('rodadas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organizador_id');
            $table->unsignedBigInteger('circuito_id');
            $table->date('fecha');   
            $table->string('titulo');   
            $table->text('descripcion')->nullable();
            $table->integer('plazas');
            $table->decimal('precio', 8, 2); 

            $table->timestamps();

             $table->foreign('organizador_id')->references('id')->on('organizadors')->onUpdate('cascade')->onDelete('restrict');
             $table->foreign('circuito_id')->references('id')->on('circuitos')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rodadas');
    }
};
