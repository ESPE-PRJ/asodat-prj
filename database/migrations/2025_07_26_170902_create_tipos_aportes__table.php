<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tipos_aporte', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 20)->unique();
            $table->string('nombre', 50);
            $table->text('descripcion')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipos_aporte');
    }
};
