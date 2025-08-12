<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Str;

class CustomEloquentUserProvider extends EloquentUserProvider
{
    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (
            empty($credentials) ||
            (count($credentials) === 1 &&
                array_key_exists('password', $credentials))
        ) {
            return;
        }

        // Para el campo de login, buscar por email o por cédula del socio relacionado
        $query = $this->newModelQuery();

        foreach ($credentials as $key => $value) {
            if (Str::contains($key, 'password')) {
                continue;
            }

            if ($key === 'email') {
                // Buscar por email o por cédula a través de la relación con socio
                $query->where(function ($q) use ($value) {
                    $q->where('email', $value)
                        ->orWhereHas('socio', function ($socioQuery) use ($value) {
                            $socioQuery->where('cedula', $value);
                        });
                });
            } else {
                $query->where($key, $value);
            }
        }

        return $query->first();
    }
}
