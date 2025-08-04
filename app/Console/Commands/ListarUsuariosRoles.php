<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ListarUsuariosRoles extends Command
{
    protected $signature = 'roles:listar-usuarios {--rol= : Filtrar por rol específico}';
    protected $description = 'Lista todos los usuarios con sus roles asignados';

    public function handle()
    {
        $rolFiltro = $this->option('rol');

        if ($rolFiltro) {
            $usuarios = User::role($rolFiltro)->get();
            $this->info("Usuarios con rol '{$rolFiltro}':");
        } else {
            $usuarios = User::with('roles')->get();
            $this->info("Todos los usuarios con sus roles:");
        }

        if ($usuarios->isEmpty()) {
            $this->warn("No se encontraron usuarios.");
            return 0;
        }

        $headers = ['ID', 'Nombre', 'Email', 'Roles', 'Fecha Creación'];
        $rows = [];

        foreach ($usuarios as $usuario) {
            $roles = $usuario->getRoleNames()->implode(', ');
            if (empty($roles)) {
                $roles = '<sin rol>';
            }

            $rows[] = [
                $usuario->id,
                $usuario->name,
                $usuario->email,
                $roles,
                $usuario->created_at->format('d/m/Y H:i'),
            ];
        }

        $this->table($headers, $rows);

        // Estadísticas
        $totalUsuarios = User::count();
        $usuariosSinRol = User::whereDoesntHave('roles')->count();
        $rolesDisponibles = Role::pluck('name')->implode(', ');

        $this->info("\nEstadísticas:");
        $this->info("- Total usuarios: {$totalUsuarios}");
        $this->info("- Usuarios sin rol: {$usuariosSinRol}");
        $this->info("- Roles disponibles: {$rolesDisponibles}");

        return 0;
    }
}