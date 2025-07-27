<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('comprobantes', function (Blueprint $table) {
            $table->id();
            $table->uuid('codigo')->unique();
            $table->foreignId('socio_id')->constrained('socios')->onDelete('cascade');
            $table->decimal('total', 12, 2);
            $table->string('metodo_pago', 50);
            $table->string('referencia_pago', 100)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comprobantes');
    }
};
