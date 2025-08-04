<?php

namespace App\Filament\Resources\Admin\SociosResource\Pages;

use App\Filament\Resources\Admin\SociosResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSocios extends EditRecord
{
    protected static string $resource = SociosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
