<?php

namespace App\Filament\Resources\Socio\AporteResource\Pages;

use App\Filament\Resources\Socio\AporteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateAporte extends CreateRecord
{
    protected static string $resource = AporteResource::class;

    public static function canAccess(array $parameters = []): bool
    {
        $user = Auth::user();
        return $user && $user->hasRole('socio') && $user->socio;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Aporte creado exitosamente';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();
        $socio = $user->socio;

        if (!$socio) {
            throw new \Exception('No tienes un perfil de socio asociado. Contacta al administrador.');
        }

        $data['socio_id'] = $socio->id;
        $data['monto'] = abs($data['monto']); // Asegurar valor positivo

        return $data;
    }
}
