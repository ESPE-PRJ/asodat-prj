<?php

namespace App\Filament\Pages\Dashboard;

use Filament\Pages\Page;
use App\Filament\Widgets\Dashboard\SocioWidgets;

class Socio extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Mi Panel';
    protected static ?string $title = 'Mi Panel';
    protected static ?string $slug = 'socio';
    protected static string $view = 'filament.pages.dashboard.socio';

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('socio');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false; // Ocultar del menú lateral para mantener solo lo esencial
    }

    protected function getHeaderWidgets(): array
    {
        return [
            SocioWidgets::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }
}
