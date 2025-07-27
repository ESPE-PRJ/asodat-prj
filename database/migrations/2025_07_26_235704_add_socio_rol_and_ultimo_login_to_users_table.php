<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table
                ->foreignId('socio_id')
                ->after('id')
                ->nullable()
                ->constrained('socios')
                ->onDelete('cascade');


            $table
                ->enum('rol', ['socio', 'admin'])
                ->after('password')
                ->default('socio');


            $table
                ->timestamp('ultimo_login')
                ->after('rol')
                ->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['socio_id']);
            $table->dropColumn('socio_id');

            $table->dropColumn('rol');
            $table->dropColumn('ultimo_login');
        });
    }
};
