<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Para poder usar ->change() necesitas doctrine/dbal instalado:
        // composer require doctrine/dbal

        Schema::table('socios', function (Blueprint $table) {
            // convierte correo en nullable
            $table->string('correo', 100)
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('socios', function (Blueprint $table) {
            // vuelve a NOT NULL
            $table->string('correo', 100)
                ->nullable(false)
                ->change();
        });
    }
};
