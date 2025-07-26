<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('socios', function (Blueprint $table) {
            $table->id();
            $table->string('cedula', 15)->unique();
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->string('campus', 50)->nullable();
            $table->enum('genero', ['M', 'F', 'O'])->nullable();
            $table->string('regimen', 50)->nullable();
            $table->string('celular', 15)->nullable();
            $table->string('cargo', 100)->nullable();
            $table->text('direccion')->nullable();
            $table->date('fecha_afiliacion');
            $table->string('correo', 100)->unique();
            $table->enum('tipo_usuario', ['nuevo', 'adherente', 'fundador']);
            $table->decimal('cupo', 12, 2)->default(0.00);
            $table->string('documento_pdf_path', 255)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('socios');
    }
};
