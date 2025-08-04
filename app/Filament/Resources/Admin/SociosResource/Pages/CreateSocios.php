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
        // Extraer datos del usuario
        $userData = [
            'name' => $data['apellidos_nombres'],
            'email' => $data['correo'],
            'password' => Hash::make($data['password']),
        ];

        $roles = $data['roles'] ?? ['socio'];
        unset($data['password'], $data['password_confirmation'], $data['roles']);

        // Usar transacción para crear usuario y socio
        DB::beginTransaction();

        try {
            // Crear usuario
            $user = User::create($userData);
            $user->assignRole($roles);

            // Crear socio
            $data['user_id'] = $user->id;
            $socio = Socio::create($data);

            DB::commit();

            // Retornar solo los datos del socio para el registro
            return $data;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
