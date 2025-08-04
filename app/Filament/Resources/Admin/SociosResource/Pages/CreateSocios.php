<?php

namespace App\Filament\Resources\Admin\SociosResource\Pages;

use App\Filament\Resources\Admin\SociosResource;
use App\Models\Socio;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateSocios extends CreateRecord
{
    protected static string $resource = SociosResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Socio creado exitosamente';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Concatenar apellidos y nombres
        $apellidos = $data['apellidos'] ?? '';
        $nombres = $data['nombres'] ?? '';
        $data['apellidos_nombres'] = trim($apellidos . ' ' . $nombres);

        // Remover campos que no van a la tabla socio
        unset($data['password'], $data['password_confirmation'], $data['roles'], $data['apellidos'], $data['nombres']);

        return $data;
    }

    protected function handleRecordCreation(array $data): Socio
    {
        // Verificar si ya existe un socio con esa cédula
        if (Socio::where('cedula', $data['cedula'])->exists()) {
            throw new \Exception('Ya existe un socio con la cédula: ' . $data['cedula']);
        }

        // Verificar si ya existe un usuario con ese email
        if (User::where('email', $data['correo'])->exists()) {
            throw new \Exception('Ya existe un usuario con el email: ' . $data['correo']);
        }

        // Extraer datos del usuario del formulario original
        $formData = $this->form->getState();
        $userData = [
            'name' => $data['apellidos_nombres'],
            'email' => $data['correo'],
            'password' => Hash::make($formData['password']),
        ];

        $roles = $formData['roles'] ?? ['socio'];

        // Usar transacción para crear socio y usuario
        DB::beginTransaction();

        try {
            // 1. Crear socio primero
            $socio = Socio::create($data);

            // 2. Crear usuario con socio_id
            $userData['socio_id'] = $socio->id;
            $user = User::create($userData);
            $user->assignRole($roles);

            DB::commit();

            return $socio;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
