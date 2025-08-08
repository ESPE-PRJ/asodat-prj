<?php

namespace App\Filament\Pages\Dashboard;

use Filament\Pages\Page;
use App\Filament\Widgets\Dashboard\AdminWidgets;

class Admin extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Administración';
    protected static ?string $title = 'Panel de Administración';
    protected static ?string $slug = 'dashboard';
    protected static string $view = 'filament.pages.dashboard.admin';

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false; // Ocultar del menú lateral para simplificar
    }

    protected function getHeaderWidgets(): array
    {
        return [
            AdminWidgets::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }
}
