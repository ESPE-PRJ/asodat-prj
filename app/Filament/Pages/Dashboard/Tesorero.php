<?php

namespace App\Filament\Pages\Dashboard;

use Filament\Pages\Page;
use App\Models\Socio;
use App\Models\Aporte;
use Carbon\Carbon;

class Tesorero extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calculator';
    protected static ?string $navigationLabel = 'Gestión Financiera';
    protected static ?string $title = 'Panel de Tesorería';
    protected static ?string $slug = 'dashboard/tesoreria';
    protected static string $view = 'filament.pages.dashboard.tesorero';

    public static function canAccess(): bool
    {
        return auth()->user()->hasAnyRole(['tesorero', 'super_admin']);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false; // Ocultar del menú lateral para simplificar
    }

    public function getViewData(): array
    {
        $currentMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        // Estadísticas generales
        $totalSocios = Socio::count();
        $aportesEsteMes = Aporte::whereMonth('fecha_aporte', $currentMonth->month)
            ->whereYear('fecha_aporte', $currentMonth->year)
            ->sum('monto');

        $aportesMesAnterior = Aporte::whereMonth('fecha_aporte', $lastMonth->month)
            ->whereYear('fecha_aporte', $lastMonth->year)
            ->sum('monto');

        $sociosQueAportaronEsteMes = Aporte::whereMonth('fecha_aporte', $currentMonth->month)
            ->whereYear('fecha_aporte', $currentMonth->year)
            ->distinct('socio_id')
            ->count();

        $nuevosIngresosEsteMes = Socio::whereMonth('fecha_afiliacion', $currentMonth->month)
            ->whereYear('fecha_afiliacion', $currentMonth->year)
            ->count();

        return [
            'totalSocios' => $totalSocios,
            'aportesEsteMes' => $aportesEsteMes,
            'aportesMesAnterior' => $aportesMesAnterior,
            'sociosQueAportaronEsteMes' => $sociosQueAportaronEsteMes,
            'nuevosIngresosEsteMes' => $nuevosIngresosEsteMes,
            'porcentajeAportes' => $totalSocios > 0 ? round(($sociosQueAportaronEsteMes / $totalSocios) * 100, 1) : 0,
        ];
    }
}
