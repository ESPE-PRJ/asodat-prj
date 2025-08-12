<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\WelcomeWidget;
use App\Filament\Widgets\Dashboard\SocioWidgets;

class Index extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Inicio';
    protected static ?string $title = 'Inicio';
    protected static string $view = 'filament.pages.index';

    protected function getHeaderWidgets(): array
    {
        $widgets = [
            WelcomeWidget::class,
        ];

        // Si el usuario tiene un socio asociado, agregar SocioWidgets
        $user = \Filament\Facades\Filament::auth()->user();
        if ($user && $user->socio_id) {
            $widgets[] = SocioWidgets::class;
        }

        return $widgets;
    }

    protected function getFooterWidgets(): array
    {
        return [];
    }
}
