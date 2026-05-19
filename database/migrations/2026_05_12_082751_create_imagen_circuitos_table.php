<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imagen_circuitos', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('circuito_id');

            $table->string('imagen');

            $table->timestamps();

            $table->foreign('circuito_id')
                ->references('id')
                ->on('circuitos')
                ->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imagen_circuitos');
    }
};