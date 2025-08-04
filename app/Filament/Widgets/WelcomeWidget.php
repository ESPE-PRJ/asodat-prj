<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class WelcomeWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $user = Auth::user();
        $userRoles = $user->getRoleNames();

        return [
            Stat::make('Usuario', $user->name)
                ->description($user->email)
                ->descriptionIcon('heroicon-o-user')
                ->color('primary'),

            Stat::make('Roles Asignados', $userRoles->count())
                ->description($userRoles->implode(', '))
                ->descriptionIcon('heroicon-o-shield-check')
                ->color('success'),
        ];
    }
}