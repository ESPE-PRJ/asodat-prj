<?php

namespace App\Filament\Resources\AporteResource\Pages;

use App\Filament\Resources\AporteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateAporte extends CreateRecord
{
    protected static string $resource = AporteResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Aporte creado')
            ->body('El aporte se ha creado correctamente.');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Asegurar que el monto sea positivo
        if (isset($data['monto']) && $data['monto'] < 0) {
            $data['monto'] = abs($data['monto']);
        }

        return $data;
    }
}
