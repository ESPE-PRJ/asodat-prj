<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\WelcomeWidget;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Inicio';
    protected static ?string $title = 'Inicio';

    protected function getHeaderWidgets(): array
    {
        return [
            WelcomeWidget::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }
}