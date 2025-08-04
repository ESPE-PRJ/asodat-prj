<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AsignarMultiplesRoles extends Command
{
    protected $signature = 'roles:asignar-multiples {email} {roles*} {--replace : Reemplazar roles existentes en lugar de agregar}';
    protected $description = 'Asigna múltiples roles a un usuario por email';

    public function handle()
    {
        $email = $this->argument('email');
        $roles = $this->argument('roles');
        $replace = $this->option('replace');

        // Buscar usuario
        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->error("Usuario con email {$email} no encontrado");
            return 1;
        }

        // Verificar que todos los roles existen
        $rolesExistentes = Role::whereIn('name', $roles)->pluck('name')->toArray();
        $rolesNoExistentes = array_diff($roles, $rolesExistentes);

        if (!empty($rolesNoExistentes)) {
            $this->error("Los siguientes roles no existen: " . implode(', ', $rolesNoExistentes));
            $this->info("Roles disponibles:");
            $this->table(['Roles'], Role::all()->pluck('name')->map(fn($name) => [$name]));
            return 1;
        }

        // Mostrar roles actuales
        $rolesActuales = $user->getRoleNames();
        $this->info("Roles actuales de {$user->name}: " . $rolesActuales->implode(', '));

        if ($replace) {
            // Reemplazar roles existentes
            $user->syncRoles($roles);
            $this->info("Roles reemplazados correctamente");
        } else {
            // Agregar roles (sin reemplazar)
            $user->assignRole($roles);
            $this->info("Roles agregados correctamente");
        }

        // Mostrar roles finales
        $rolesFinales = $user->getRoleNames();
        $this->info("Roles finales: " . $rolesFinales->implode(', '));

        return 0;
    }
}