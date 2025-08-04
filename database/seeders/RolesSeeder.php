<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // Crear roles básicos
        $roles = [
            'presidente',
            'socio'
        ];

        foreach ($roles as $rol) {
            Role::firstOrCreate(['name' => $rol]);
        }

        $this->command->info('Roles creados correctamente');
        $this->command->info('Roles disponibles: ' . implode(', ', $roles));
    }
}