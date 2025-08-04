<?php

namespace App\Filament\Resources\Admin\SociosResource\Pages;

use App\Filament\Resources\Admin\SociosResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSocios extends ListRecords
{
    protected static string $resource = SociosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nuevo Socio'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // Puedes agregar widgets aquí si es necesario
        ];
    }
}
