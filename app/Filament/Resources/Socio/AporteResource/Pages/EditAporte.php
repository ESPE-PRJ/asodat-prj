<?php

namespace App\Filament\Resources\Socio\AporteResource\Pages;

use App\Filament\Resources\Socio\AporteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditAporte extends EditRecord
{
    protected static string $resource = AporteResource::class;

    public static function canAccess(array $parameters = []): bool
    {
        $user = Auth::user();
        return $user && $user->hasRole('socio') && $user->socio;
    }

    protected function getHeaderActions(): array
    {
        return [
            // No delete action for socio
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Aporte actualizado exitosamente';
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['monto'] = abs($data['monto']); // Asegurar valor positivo
        return $data;
    }
}
