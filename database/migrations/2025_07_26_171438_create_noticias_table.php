<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 255);
            $table->text('contenido');
            $table->string('categoria', 50)->nullable();
            $table->string('imagen_path', 255)->nullable();
            $table->timestamp('publicar_desde');
            $table->timestamp('publicar_hasta')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('noticias');
    }
};
