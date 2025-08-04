<?php

namespace App\Filament\Widgets\Dashboard;

use App\Models\Aporte;
use App\Models\Socio;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class PresidenteWidgets extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $currentYear = now()->year;

        // Consultas optimizadas para presidente
        $totalAnoActual = Aporte::whereYear('periodo', $currentYear)
            ->where('estado', 'pagado')
            ->sum('monto');

        $numeroAportantes = Aporte::distinct('socio_id')->count();
        $totalSocios = Socio::count();
        $aportesPendientes = Aporte::where('estado', 'pendiente')->count();

        $totalAnoAnterior = Aporte::whereYear('periodo', $currentYear - 1)
            ->where('estado', 'pagado')
            ->sum('monto');

        $crecimiento = $totalAnoAnterior > 0
            ? (($totalAnoActual - $totalAnoAnterior) / $totalAnoAnterior) * 100
            : 0;

        return [
            Stat::make('Total Aportado ' . $currentYear, '$' . number_format($totalAnoActual, 2))
                ->description('Aportes pagados este año')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('success'),

            Stat::make('Número de Aportantes', $numeroAportantes)
                ->description('Socios que han aportado')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),

            Stat::make('Total de Socios', $totalSocios)
                ->description('Socios registrados')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('info'),

            Stat::make('Crecimiento vs ' . ($currentYear - 1), number_format($crecimiento, 1) . '%')
                ->description($crecimiento >= 0 ? 'Incremento' : 'Decremento')
                ->descriptionIcon($crecimiento >= 0 ? 'heroicon-o-arrow-up' : 'heroicon-o-arrow-down')
                ->color($crecimiento >= 0 ? 'success' : 'danger'),
        ];
    }
}
