<?php

namespace App\Filament\Widgets\Dashboard;

use App\Models\Aporte;
use App\Models\Socio;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SocioWidgets extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $user = Auth::user();
        $socio = $user->socio;

        if (!$socio) {
            return [
                Stat::make('Error', 'No se encontró información de socio')
                    ->description('Contacta al administrador')
                    ->color('danger'),
            ];
        }

        // Total de aportes del socio
        $totalAportes = Aporte::where('socio_id', $socio->id)->count();

        // Fecha de vencimiento de afiliación
        $fechaAfiliacion = Carbon::parse($socio->fecha_afiliacion);
        $fechaVencimiento = $fechaAfiliacion->addYear();
        $diasRestantes = now()->diffInDays($fechaVencimiento, false);

        // Monto total aportado
        $montoTotal = Aporte::where('socio_id', $socio->id)->sum('monto');

        // Aportes pendientes
        $aportesPendientes = Aporte::where('socio_id', $socio->id)
            ->where('estado', 'pendiente')
            ->count();

        return [
            Stat::make('Mis Aportes', $totalAportes)
                ->description('Tus aportes registrados')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('primary'),

            Stat::make('Monto Total Aportado', '$' . number_format($montoTotal, 2))
                ->description('Suma de todos tus aportes')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('success'),

            Stat::make('Aportes Pendientes', $aportesPendientes)
                ->description('Aportes por pagar')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('Vencimiento Afiliación', $diasRestantes > 0 ? $diasRestantes . ' días' : 'Vencida')
                ->description($fechaVencimiento->format('d/m/Y'))
                ->descriptionIcon('heroicon-o-calendar')
                ->color($diasRestantes > 30 ? 'success' : ($diasRestantes > 0 ? 'warning' : 'danger')),
        ];
    }
}
