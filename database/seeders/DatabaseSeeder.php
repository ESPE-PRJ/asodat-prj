<?php

namespace Database\Seeders;

use App\Models\Comprobante;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AportesCsvSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            SociosCsvSeeder::class,
            UsuariosCsvSeeder::class,
            AportesCsvSeeder::class,
            ComprobanteCsvSeeder::class,
            NoticiasSeeder::class,
        ]);

        $this->command->info("→ Importación de datos completada.");
    }
}
