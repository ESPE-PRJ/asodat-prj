<?php

namespace App\Filament\Resources\Admin\SociosResource\Pages;

use App\Filament\Resources\Admin\SociosResource;
use App\Models\Socio;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EditSocios extends EditRecord
{
    protected static string $resource = SociosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Socio actualizado exitosamente';
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $socio = $this->record;
        $user = $socio->user;

        // Extraer datos del usuario
        $userData = [
            'name' => $data['apellidos_nombres'],
            'email' => $data['correo'],
        ];

        // Si se proporcionó una nueva contraseña
        if (isset($data['password']) && !empty($data['password'])) {
            $userData['password'] = Hash::make($data['password']);
        }

        $roles = $data['roles'] ?? ['socio'];
        unset($data['password'], $data['password_confirmation'], $data['roles']);

        // Usar transacción para actualizar usuario y socio
        DB::beginTransaction();

        try {
            // Actualizar usuario
            $user->update($userData);
            $user->syncRoles($roles);

            // Actualizar socio
            $socio->update($data);

            DB::commit();

            // Retornar solo los datos del socio para el registro
            return $data;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $socio = $this->record;
        $user = $socio->user;

        // Agregar datos del usuario al formulario
        $data['roles'] = $user->getRoleNames()->toArray();

        return $data;
    }
}
