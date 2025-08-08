<?php

namespace App\Filament\Resources\Admin\SociosResource\Pages;

use App\Filament\Resources\Admin\SociosResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListSocios extends ListRecords
{
    protected static string $resource = SociosResource::class;

    protected function getHeaderActions(): array
    {
        $actions = [
            Actions\CreateAction::make()
                ->label('Nuevo Socio'),
        ];

        // Agregar botón de auditorías solo para usuarios autorizados
        /** @var \App\Models\User */
        $user = Auth::user();
        if ($user && $user->hasAnyRole(['super_admin', 'secretaria', 'tesorero'])) {
            $actions[] = Actions\Action::make('audits')
                ->label('Ver Auditorías')
                ->icon('heroicon-o-document-text')
                ->color('info')
                ->url('/sys/auditorias-socios');
        }

        return $actions;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // Puedes agregar widgets aquí si es necesario
        ];
    }
}
