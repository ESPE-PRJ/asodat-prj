<?php

namespace App\Filament\Widgets\Dashboard\Charts;

use App\Models\Aporte;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AportesStats extends ChartWidget
{
    protected static ?int $sort = 2;

    protected static string $chartId = 'aportes-stats';

    public function getColumnSpan(): int
    {
        return 2;
    }

    public static function canView(): bool
    {
        return auth()->user()->hasAnyRole(['presidente', 'super_admin']);
    }

    public function getHeading(): string
    {
        return 'Evolución de Aportes';
    }

    protected function getData(): array
    {
        $labels = [];
        $dataAnoActual = [];
        $dataAnoAnterior = [];

        $currentYear = now()->year;
        $previousYear = $currentYear - 1;

        // Generar datos para los últimos 2 años mes a mes
        for ($month = 1; $month <= 12; $month++) {
            $monthName = Carbon::create()->month($month)->format('M');
            $labels[] = $monthName;

            // Datos del año actual
            $totalActual = Aporte::whereYear('periodo', $currentYear)
                ->whereMonth('periodo', $month)
                ->where('estado', 'pagado')
                ->sum('monto');
            $dataAnoActual[] = round($totalActual, 2);

            // Datos del año anterior
            $totalAnterior = Aporte::whereYear('periodo', $previousYear)
                ->whereMonth('periodo', $month)
                ->where('estado', 'pagado')
                ->sum('monto');
            $dataAnoAnterior[] = round($totalAnterior, 2);
        }

        return [
            'datasets' => [
                [
                    'label' => $currentYear,
                    'data' => $dataAnoActual,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
                    'borderColor' => '#10B981',
                    'borderWidth' => 2,
                    'tension' => 0.4,
                ],
                [
                    'label' => $previousYear,
                    'data' => $dataAnoAnterior,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'borderColor' => '#3B82F6',
                    'borderWidth' => 2,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'x' => [
                    'display' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Meses',
                    ],
                ],
                'y' => [
                    'display' => true,
                    'beginAtZero' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Monto ($)',
                    ],
                    'ticks' => [
                        'display' => true,
                        'color' => '#9CA3AF',
                        'font' => [
                            'size' => 12,
                        ],
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) { return context.dataset.label + ": $" + context.parsed.y.toLocaleString(); }',
                    ],
                ],
            ],
            'responsive' => true,
            'maintainAspectRatio' => false,
        ];
    }
}
