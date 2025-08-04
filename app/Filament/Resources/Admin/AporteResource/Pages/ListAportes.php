<?php

namespace App\Filament\Resources\Admin\AporteResource\Pages;

use App\Filament\Resources\Admin\AporteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAportes extends ListRecords
{
    protected static string $resource = AporteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
