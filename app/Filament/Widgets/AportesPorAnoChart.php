<?php

namespace App\Filament\Widgets;

use App\Models\Aporte;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AportesPorAnoChart extends ChartWidget
{
    protected static ?int $sort = 3;

    public static function canView(): bool
    {
        return auth()->user()->hasAnyRole(['presidente', 'super_admin']);
    }

    public function getHeading(): string
    {
        return 'Aportes por Año';
    }

    protected function getData(): array
    {
        $years = [];
        $data = [];

        // Obtener datos de los últimos 5 años
        for ($i = 4; $i >= 0; $i--) {
            $year = now()->subYears($i)->year;
            $years[] = $year;

            $total = Aporte::whereYear('periodo', $year)
                ->where('estado', 'pagado')
                ->sum('monto');

            $data[] = round($total, 2);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Aportado ($)',
                    'data' => $data,
                    'backgroundColor' => '#10B981',
                    'borderColor' => '#059669',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $years,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => 'function(value) { return "$" + value.toLocaleString(); }',
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
        ];
    }
}