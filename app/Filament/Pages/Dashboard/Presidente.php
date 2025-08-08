<?php

namespace App\Filament\Pages\Dashboard;

use Filament\Pages\Page;
use App\Filament\Widgets\Dashboard\PresidenteWidgets;
use App\Filament\Widgets\Dashboard\Charts\AportesStats;

class Presidente extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Gestión';
    protected static ?string $title = 'Panel de Gestión';
    protected static ?string $slug = 'dashboard/gestion';
    protected static string $view = 'filament.pages.dashboard.presidente';

    public static function canAccess(): bool
    {
        return auth()->user()->hasAnyRole(['presidente', 'super_admin']);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false; // Ocultar del menú lateral para simplificar
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PresidenteWidgets::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            AportesStats::class,
        ];
    }
}
