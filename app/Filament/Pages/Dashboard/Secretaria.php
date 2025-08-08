<?php

namespace App\Filament\Pages\Dashboard;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Secretaria extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboard.secretaria';

    protected static ?string $title = 'Dashboard - Secretaria';

    protected static ?string $navigationLabel = 'Dashboard Secretaria';

    protected static ?string $navigationGroup = 'Dashboard';

    public static function canAccess(): bool
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        return $user && $user->hasRole('secretaria');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false; // Ocultar del menú lateral
    }

    public function getTitle(): string
    {
        return 'Panel de Secretaria';
    }

    public function getHeading(): string
    {
        return 'Bienvenida, ' . Auth::user()->name;
    }
}
