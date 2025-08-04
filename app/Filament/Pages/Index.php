<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\WelcomeWidget;

class Index extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Inicio';
    protected static ?string $title = 'Inicio';
    protected static string $view = 'filament.pages.index';

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
