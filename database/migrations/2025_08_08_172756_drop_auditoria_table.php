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
        // Eliminar la tabla auditoria ya que no se está usando
        // El sistema de auditorías utiliza la tabla 'audits' del paquete laravel-auditing
        Schema::dropIfExists('auditoria');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recrear la tabla auditoria en caso de rollback
        // Basado en la migración original 2025_07_26_171412_create_auditoria_table.php
        Schema::create('auditoria', function (Blueprint $table) {
            $table->id();
            $table->string('tabla_afectada', 50);
            $table->enum('operacion', ['INSERT', 'UPDATE', 'DELETE', 'LOGIN']);
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->json('detalles');
            $table->timestamps();
        });
    }
};
