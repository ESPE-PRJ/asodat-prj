<?php

namespace App\Filament\Resources\Admin\AporteResource\Pages;

use App\Filament\Resources\Admin\AporteResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAporte extends ViewRecord
{
    protected static string $resource = AporteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // Aquí puedes agregar widgets si los necesitas
        ];
    }
}
