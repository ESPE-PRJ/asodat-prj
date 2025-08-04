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

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Separar apellidos_nombres en campos individuales
        $apellidosNombres = $data['apellidos_nombres'] ?? '';
        $partes = explode(' ', $apellidosNombres, 2);

        $data['apellidos'] = $partes[0] ?? '';
        $data['nombres'] = $partes[1] ?? '';

        // Cargar roles del usuario asociado
        $socio = $this->record;
        $user = User::where('socio_id', $socio->id)->first();
        if ($user) {
            $data['roles'] = $user->getRoleNames()->toArray();
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Concatenar apellidos y nombres
        $apellidos = $data['apellidos'] ?? '';
        $nombres = $data['nombres'] ?? '';
        $data['apellidos_nombres'] = trim($apellidos . ' ' . $nombres);

        $socio = $this->record;
        $user = User::where('socio_id', $socio->id)->first();

        // Verificar si ya existe otro socio con esa cédula (excluyendo el actual)
        if (Socio::where('cedula', $data['cedula'])->where('id', '!=', $socio->id)->exists()) {
            throw new \Exception('Ya existe otro socio con la cédula: ' . $data['cedula']);
        }

        // Verificar si ya existe otro usuario con ese email (excluyendo el actual)
        if ($user && User::where('email', $data['correo'])->where('id', '!=', $user->id)->exists()) {
            throw new \Exception('Ya existe otro usuario con el email: ' . $data['correo']);
        }

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
        unset($data['password'], $data['password_confirmation'], $data['roles'], $data['apellidos'], $data['nombres']);

        // Usar transacción para actualizar socio y usuario
        DB::beginTransaction();

        try {
            // Actualizar socio
            $socio->update($data);

            // Actualizar usuario
            if ($user) {
                $user->update($userData);
                $user->syncRoles($roles);
            }

            DB::commit();

            // Retornar solo los datos del socio para el registro
            return $data;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
