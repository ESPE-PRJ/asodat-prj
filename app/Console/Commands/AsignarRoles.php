<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AsignarRoles extends Command
{
    protected $signature = 'roles:asignar {email} {rol}';
    protected $description = 'Asigna un rol a un usuario por email';

    public function handle()
    {
        $email = $this->argument('email');
        $rol = $this->argument('rol');

        // Buscar usuario
        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->error("Usuario con email {$email} no encontrado");
            return 1;
        }

        // Verificar que el rol existe
        $role = Role::where('name', $rol)->first();
        if (!$role) {
            $this->error("Rol '{$rol}' no encontrado. Roles disponibles:");
            $this->table(['Roles'], Role::all()->pluck('name')->map(fn($name) => [$name]));
            return 1;
        }

        // Asignar rol
        $user->assignRole($rol);

        $this->info("Rol '{$rol}' asignado correctamente a {$user->name} ({$email})");

        // Mostrar roles actuales del usuario
        $roles = $user->getRoleNames();
        $this->info("Roles actuales: " . $roles->implode(', '));

        return 0;
    }
}