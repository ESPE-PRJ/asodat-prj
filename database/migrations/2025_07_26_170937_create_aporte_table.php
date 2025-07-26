<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('aportes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('socio_id')->constrained('socios')->onDelete('cascade');
            $table->foreignId('tipo_aporte_id')->constrained('tipos_aporte')->onDelete('cascade');
            $table->date('periodo');
            $table->decimal('monto', 12, 2);
            $table->enum('estado', ['pendiente', 'pagado', 'vencido'])->default('pendiente');
            $table->timestamps();
            $table->index('periodo');
        });
    }

    public function down()
    {
        Schema::dropIfExists('aportes');
    }
};
