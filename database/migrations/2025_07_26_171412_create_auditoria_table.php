<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('auditoria', function (Blueprint $table) {
            $table->id();
            $table->string('tabla_afectada', 50);
            $table->enum('operacion', ['INSERT', 'UPDATE', 'DELETE', 'LOGIN']);
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->json('detalles');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('auditoria');
    }
};
