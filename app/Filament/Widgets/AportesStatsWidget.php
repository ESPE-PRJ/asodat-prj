<?php

namespace App\Filament\Widgets;

use App\Models\Aporte;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AportesStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalAportes = Aporte::count();
        $aportesPendientes = Aporte::where('estado', 'pendiente')->count();
        $aportesPagados = Aporte::where('estado', 'pagado')->count();
        $aportesVencidos = Aporte::where('estado', 'vencido')->count();
        $montoTotal = Aporte::sum('monto');
        $montoPendiente = Aporte::where('estado', 'pendiente')->sum('monto');

        return [
            Stat::make('Total de Aportes', $totalAportes)
                ->description('Todos los aportes registrados')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('primary'),

            Stat::make('Aportes Pendientes', $aportesPendientes)
                ->description('Aportes por cobrar')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Aportes Pagados', $aportesPagados)
                ->description('Aportes cobrados')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Aportes Vencidos', $aportesVencidos)
                ->description('Aportes vencidos')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),

            Stat::make('Monto Total', '$' . number_format($montoTotal, 2))
                ->description('Suma de todos los aportes')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('info'),

            Stat::make('Monto Pendiente', '$' . number_format($montoPendiente, 2))
                ->description('Monto por cobrar')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}