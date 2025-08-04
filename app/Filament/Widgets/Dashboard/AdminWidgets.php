<?php

namespace App\Filament\Widgets\Dashboard;

use App\Models\User;
use App\Models\Aporte;
use App\Models\Socio;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Spatie\Permission\Models\Role;

class AdminWidgets extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Consultas optimizadas para super_admin
        $totalUsuarios = User::count();
        $usuariosSinRol = User::whereDoesntHave('roles')->count();
        $totalAportes = Aporte::count();
        $montoTotal = Aporte::sum('monto');

        // Estadísticas de usuarios por roles
        $usuariosPorRol = [];
        $roles = Role::all();

        foreach ($roles as $role) {
            $count = User::role($role->name)->count();
            $usuariosPorRol[$role->name] = $count;
        }

        return [
            Stat::make('Total de Usuarios', $totalUsuarios)
                ->description('Usuarios registrados en el sistema')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),

            Stat::make('Usuarios sin Rol', $usuariosSinRol)
                ->description('Necesitan asignación de rol')
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color('warning'),

            Stat::make('Super Admins', $usuariosPorRol['super_admin'] ?? 0)
                ->description('Administradores del sistema')
                ->descriptionIcon('heroicon-o-shield-check')
                ->color('danger'),

            Stat::make('Presidentes', $usuariosPorRol['presidente'] ?? 0)
                ->description('Gestores de la asociación')
                ->descriptionIcon('heroicon-o-star')
                ->color('warning'),

            Stat::make('Socios', $usuariosPorRol['socio'] ?? 0)
                ->description('Miembros de la asociación')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success'),

            Stat::make('Total de Aportes', $totalAportes)
                ->description('Aportes en el sistema')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('info'),

            Stat::make('Monto Total Sistema', '$' . number_format($montoTotal, 2))
                ->description('Suma de todos los aportes')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('success'),
        ];
    }
}
