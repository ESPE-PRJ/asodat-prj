<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AsignarSocioPorDefecto extends Command
{
    protected $signature = 'roles:socio-por-defecto {--force : Forzar asignación a todos los usuarios}';
    protected $description = 'Asigna el rol de socio a todos los usuarios que no tengan rol asignado';

    public function handle()
    {
        // Verificar que el rol socio existe
        $rolSocio = Role::where('name', 'socio')->first();
        if (!$rolSocio) {
            $this->error('El rol "socio" no existe. Ejecuta primero: php artisan db:seed --class=RolesSeeder');
            return 1;
        }

        if ($this->option('force')) {
            // Asignar a TODOS los usuarios
            $usuarios = User::all();
            $this->info("Asignando rol 'socio' a TODOS los usuarios ({$usuarios->count()} usuarios)...");
        } else {
            // Solo usuarios sin roles
            $usuarios = User::whereDoesntHave('roles')->get();
            $this->info("Asignando rol 'socio' a usuarios sin roles ({$usuarios->count()} usuarios)...");
        }

        $asignados = 0;
        foreach ($usuarios as $usuario) {
            if (!$usuario->hasRole('socio')) {
                $usuario->assignRole('socio');
                $asignados++;
                $this->line("✓ Asignado a: {$usuario->name} ({$usuario->email})");
            } else {
                $this->line("- Ya tiene rol: {$usuario->name} ({$usuario->email})");
            }
        }

        $this->info("Proceso completado. {$asignados} usuarios recibieron el rol 'socio'.");

        // Mostrar estadísticas
        $totalUsuarios = User::count();
        $usuariosConSocio = User::role('socio')->count();
        $usuariosSinRol = User::whereDoesntHave('roles')->count();

        $this->info("Estadísticas:");
        $this->info("- Total usuarios: {$totalUsuarios}");
        $this->info("- Usuarios con rol 'socio': {$usuariosConSocio}");
        $this->info("- Usuarios sin rol: {$usuariosSinRol}");

        return 0;
    }
}