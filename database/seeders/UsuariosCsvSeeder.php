<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Socio;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UsuariosCsvSeeder extends Seeder
{
    /**
     * Convierte texto a UTF-8 y reemplaza caracteres especiales
     */
    private function cleanText($string)
    {
        if (empty($string)) {
            return $string;
        }

        // Detectar y convertir codificación
        $encoding = mb_detect_encoding($string, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true);
        if ($encoding && $encoding !== 'UTF-8') {
            $string = mb_convert_encoding($string, 'UTF-8', $encoding);
        }

        // Aplicar reemplazo de caracteres especiales
        return $this->replaceSpecialChars($string);
    }

    /**
     * Reemplaza caracteres especiales por equivalentes ASCII
     */
    private function replaceSpecialChars($string)
    {
        if (empty($string))
            return $string;

        $replacements = [
            'Ñ' => 'N',
            'ñ' => 'n',
            'Á' => 'A',
            'á' => 'a',
            'É' => 'E',
            'é' => 'e',
            'Í' => 'I',
            'í' => 'i',
            'Ó' => 'O',
            'ó' => 'o',
            'Ú' => 'U',
            'ú' => 'u',
            'Ü' => 'U',
            'ü' => 'u',
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $string);
    }

    public function run()
    {
        // Primero, asegurar que los roles existan
        $this->command->info("🔧 Verificando y creando roles de Spatie...");
        $this->crearRolesSpatie();

        $this->command->info("→ Cargando contraseñas desde iniciosesion_old.csv…");

        // 1) Lee el CSV de inicios de sesión para mapear cedula → contraseña
        $pwdPath = database_path('data/iniciosesion_old.csv');
        if (!file_exists($pwdPath)) {
            $this->command->error("No encontré iniciosesion_old.csv en: {$pwdPath}");
            return;
        }
        $pwdFile = new \SplFileObject($pwdPath);
        $pwdFile->setFlags(
            \SplFileObject::READ_CSV
                | \SplFileObject::SKIP_EMPTY
                | \SplFileObject::DROP_NEW_LINE
        );
        $pwdFile->setCsvControl(';', '"', '\\');
        $raw = $pwdFile->fgetcsv();
        $pwdHdr = array_map(fn($h) => trim(strtolower(preg_replace('/^\x{FEFF}/u', '', $h))), $raw);
        $passwords = [];
        while (!$pwdFile->eof()) {
            $row = $pwdFile->fgetcsv();
            if (!is_array($row) || count($row) !== count($pwdHdr)) {
                continue;
            }
            $r = array_combine($pwdHdr, $row);
            $ced = preg_replace('/\D/', '', $r['cedula'] ?? '');
            $pass = trim($r['contrasena'] ?? '');
            if ($ced && $pass !== '') {
                $passwords[$ced] = $pass;
            }
        }

        $this->command->info("→ Cargando nombres desde cupossocios_old.csv…");

        // Leer cupossocios_old.csv y crear el array de nombres
        $cuposPath = database_path('data/cupossocios_old.csv');
        $nombresPorCedula = [];
        if (file_exists($cuposPath)) {
            // Leer y convertir codificación del archivo
            $cuposContent = file_get_contents($cuposPath);
            $cuposEncoding = mb_detect_encoding($cuposContent, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true);
            if ($cuposEncoding && $cuposEncoding !== 'UTF-8') {
                $cuposContent = mb_convert_encoding($cuposContent, 'UTF-8', $cuposEncoding);
                file_put_contents($cuposPath . '.utf8', $cuposContent);
                $cuposPath = $cuposPath . '.utf8';
            }

            $cuposFile = new \SplFileObject($cuposPath);
            $cuposFile->setFlags(
                \SplFileObject::READ_CSV
                    | \SplFileObject::SKIP_EMPTY
                    | \SplFileObject::DROP_NEW_LINE
            );
            $cuposFile->setCsvControl(';', '"', '\\');
            $hdrCupos = $cuposFile->fgetcsv();
            $idxCedula = array_search('cedula', array_map('strtolower', $hdrCupos));
            $idxNombre = array_search('nombrecompleto', array_map('strtolower', $hdrCupos));
            while (!$cuposFile->eof()) {
                $row = $cuposFile->fgetcsv();
                if (!is_array($row) || count($row) < max($idxCedula, $idxNombre) + 1)
                    continue;
                $ced = preg_replace('/\D/', '', $row[$idxCedula] ?? '');
                $nombre = $this->cleanText(trim($row[$idxNombre] ?? ''));
                if ($ced && $nombre) {
                    $nombresPorCedula[$ced] = $nombre;
                }
            }
        } else {
            $this->command->warn("No encontré cupossocios_old.csv en: {$cuposPath}");
        }

        $this->command->info("→ Importando usuarios desde socios_old.csv…");

        // 2) Lee el CSV de socios para crear usuarios
        $path = database_path('data/socios_old.csv');
        if (!file_exists($path)) {
            $this->command->error("No encontré socios_old.csv en: {$path}");
            return;
        }

        // Leer y convertir codificación del archivo
        $sociosContent = file_get_contents($path);
        $sociosEncoding = mb_detect_encoding($sociosContent, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true);
        if ($sociosEncoding && $sociosEncoding !== 'UTF-8') {
            $sociosContent = mb_convert_encoding($sociosContent, 'UTF-8', $sociosEncoding);
            file_put_contents($path . '.utf8', $sociosContent);
            $path = $path . '.utf8';
        }

        $file = new \SplFileObject($path);
        $file->setFlags(
            \SplFileObject::READ_CSV
                | \SplFileObject::SKIP_EMPTY
                | \SplFileObject::DROP_NEW_LINE
        );
        $file->setCsvControl(';', '"', '\\');
        $rawHdr = $file->fgetcsv();
        $hdr = array_map(fn($h) => trim(strtolower(preg_replace('/^\x{FEFF}/u', '', $h))), $rawHdr);

        $allowedRoles = ['socio', 'presidente', 'tesorero', 'secretaria', 'administrador'];
        $count = 0;

        while (!$file->eof()) {
            $row = $file->fgetcsv();
            if (!is_array($row) || count($row) !== count($hdr)) {
                continue;
            }
            $data = array_combine($hdr, $row);

            // 1) Sanea cédula
            $cedula = preg_replace('/\D/', '', $data['cedula'] ?? '');
            if (!$cedula) {
                $this->command->warn("Fila sin cédula, salto.");
                continue;
            }
            // 2) Obtiene o genera email
            $email = $this->cleanText(trim($data['correo'] ?? ''));
            if ($email === '') {
                // Generamos un correo ficticio único
                $email = "{$cedula}@noemail.local";
                $this->command->warn("Email faltante para {$cedula}, asignado {$email}");
            }
            $oldRol = strtolower($this->cleanText(trim($data['rol'] ?? 'socio')));

            $socio = Socio::where('cedula', $cedula)->first();
            if (!$socio) {
                $this->command->warn("Socio {$cedula} no existe, salto usuario.");
                continue;
            }

            // Determina rol válido
            $rol = in_array($oldRol, $allowedRoles) ? $oldRol : 'socio';

            // Obtener contraseña del array o usar una por defecto
            $password = $passwords[$cedula] ?? 'password123';

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'socio_id' => $socio->id,
                    'name' => $this->cleanText($nombresPorCedula[$cedula] ?? 'Usuario'),
                    'password' => Hash::make($password),
                    'rol' => $rol,
                ]
            );

            // Asignar rol usando Spatie Laravel Permission
            if ($user->wasRecentlyCreated || !$user->hasRole($rol)) {
                // Mapear roles del CSV a roles de Spatie
                $spatieRoleMap = [
                    'administrador' => 'super_admin',
                    'presidente' => 'presidente',
                    'tesorero' => 'tesorero',
                    'secretaria' => 'secretaria',
                    'socio' => 'socio'
                ];

                $spatieRole = $spatieRoleMap[$rol] ?? 'socio';

                // Determinar qué roles asignar
                $rolesToAssign = [$spatieRole];
                
                // Si el usuario tiene un rol administrativo (secretaria, tesorero, presidente), 
                // también debe tener el rol de socio
                if (in_array($spatieRole, ['secretaria', 'tesorero', 'presidente'])) {
                    $rolesToAssign[] = 'socio';
                    $this->command->info("Usuario {$email} - Rol principal: {$spatieRole} + rol socio");
                } else {
                    $this->command->info("Usuario {$email} - Rol asignado: {$spatieRole}");
                }

                // Limpiar roles existentes y asignar los nuevos
                $user->syncRoles($rolesToAssign);
            }

            $count++;
        }

        $this->command->info("Importación de usuarios completada. Total: {$count}");
    }

    /**
     * Crea los roles de Spatie si no existen
     */
    private function crearRolesSpatie()
    {
        $roles = [
            'super_admin',
            'presidente',
            'socio',
            'secretaria',
            'tesorero'
        ];

        $rolesCreados = 0;
        foreach ($roles as $rol) {
            if (!Role::where('name', $rol)->exists()) {
                Role::create(['name' => $rol]);
                $rolesCreados++;
                $this->command->info("✅ Rol '{$rol}' creado");
            } else {
                $this->command->info("ℹ️  Rol '{$rol}' ya existe");
            }
        }

        if ($rolesCreados > 0) {
            $this->command->info("🎉 Se crearon {$rolesCreados} roles nuevos");
        } else {
            $this->command->info("✅ Todos los roles ya existían");
        }
    }
}
