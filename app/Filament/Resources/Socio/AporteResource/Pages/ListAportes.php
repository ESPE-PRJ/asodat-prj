<?php

namespace App\Filament\Resources\Socio\AporteResource\Pages;

use App\Filament\Resources\Socio\AporteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAportes extends ListRecords
{
    protected static string $resource = AporteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nuevo Aporte'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // Puedes agregar widgets aquí si es necesario
        ];
    }
}
