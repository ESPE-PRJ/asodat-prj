<?php

namespace App\Filament\Resources\Admin\AporteResource\Pages;

use App\Filament\Resources\Admin\AporteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditAporte extends EditRecord
{
    protected static string $resource = AporteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Aporte actualizado')
            ->body('El aporte se ha actualizado correctamente.');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Asegurar que el monto sea positivo
        if (isset($data['monto']) && $data['monto'] < 0) {
            $data['monto'] = abs($data['monto']);
        }

        return $data;
    }
}
