<?php

namespace App\Filament\Resources\Admin\SociosResource\Pages;

use App\Filament\Resources\Admin\SociosResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSocios extends ViewRecord
{
    protected static string $resource = SociosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}