<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('comprobante_detalle', function (Blueprint $table) {
            $table->foreignId('comprobante_id')->constrained('comprobantes')->onDelete('cascade');
            $table->foreignId('aporte_id')->constrained('aportes')->onDelete('cascade');
            $table->decimal('monto_aplicado', 12, 2);
            $table->primary(['comprobante_id', 'aporte_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('comprobante_detalle');
    }
};
