<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Socio;
use Carbon\Carbon;

class SociosCsvSeeder extends Seeder
{
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
        $this->command->info("→ Leyendo CSV de cupossocios…");

        // 1) Carga el mapa cédula → cupo
        $cuposPath = database_path('data/cupossocios_old.csv');
        $cupos = [];
        if (file_exists($cuposPath)) {
            // Leer y convertir codificación del archivo de cupos
            $cuposContent = file_get_contents($cuposPath);
            $cuposEncoding = mb_detect_encoding($cuposContent, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true);
            if ($cuposEncoding && $cuposEncoding !== 'UTF-8') {
                $cuposContent = mb_convert_encoding($cuposContent, 'UTF-8', $cuposEncoding);
            }

            $cuposTempFile = tempnam(sys_get_temp_dir(), 'cupos_utf8_');
            file_put_contents($cuposTempFile, $cuposContent);

            $f = new \SplFileObject($cuposTempFile); // Abre el CSV
            $f->setFlags(
                \SplFileObject::READ_CSV |
                \SplFileObject::SKIP_EMPTY |
                \SplFileObject::DROP_NEW_LINE
            );
            $f->setCsvControl(';', '"', '\\');
            $raw = $f->fgetcsv();
            $head = array_map(fn($h) => trim(mb_strtolower($h)), $raw);
            while (!$f->eof()) {
                $row = $f->fgetcsv();
                if (!is_array($row) || count($row) !== count($head))
                    continue;
                $r = array_combine($head, $row);
                // saneamos cédula y cupo
                $cedula = preg_replace('/\D/', '', $r['cedula'] ?? '');
                $cupo = isset($r['cupo']) ? floatval(str_replace(',', '.', $r['cupo'])) : 0;
                if ($cedula) {
                    $cupos[$cedula] = $cupo;
                }
            }
        } else {
            $this->command->warn("No encontré cupossocios en: {$cuposPath}");
        }

        // Limpiar archivo temporal de cupos
        if (isset($cuposTempFile) && file_exists($cuposTempFile)) {
            unlink($cuposTempFile);
        }

        $this->command->info("→ Leyendo CSV de socios…");

        // 2) Carga socios y les aplica cupo
        $path = database_path('data/socios_old.csv');
        if (!file_exists($path)) {
            $this->command->error("No encontré el CSV de socios en: {$path}");
            return;
        }

        // Leer el archivo completo y convertir codificación
        $csvContent = file_get_contents($path);

        // Detectar y convertir la codificación
        $encoding = mb_detect_encoding($csvContent, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true);
        if ($encoding && $encoding !== 'UTF-8') {
            $csvContent = mb_convert_encoding($csvContent, 'UTF-8', $encoding);
        }

        // Crear archivo temporal con codificación correcta
        $tempFile = tempnam(sys_get_temp_dir(), 'socios_utf8_');
        file_put_contents($tempFile, $csvContent);

        $file = new \SplFileObject($tempFile);
        $file->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );
        $file->setCsvControl(';', '"', '\\');

        // encabezados
        $rawHdr = $file->fgetcsv();
        $headers = array_map(function ($h) {
            $h = trim($h);
            $h = preg_replace('/^\x{FEFF}/u', '', $h); // quita BOM si lo hubiera
            return mb_strtolower($h);
        }, $rawHdr);

        $count = 0;
        while (!$file->eof()) {
            $row = $file->fgetcsv();
            if (!is_array($row) || count($row) !== count($headers)) {
                continue;
            }
            $data = array_combine($headers, $row);

            $cedula = preg_replace('/\D/', '', $data['cedula'] ?? '');
            if (strlen($cedula) < 5) { // Validación mínima de cédula
                continue;
            }

            // Sanear correo, si es vacío lo convertimos en null
            $correo = trim($data['correo'] ?? '');
            if ($correo === '') {
                $correo = null;
            }

            Socio::updateOrCreate(
                ['cedula' => $cedula],
                [
                    'apellidos_nombres' => $this->replaceSpecialChars(trim($data['apellidos_nombres'] ?? '')),
                    'campus' => $this->replaceSpecialChars($data['campus'] ?? null),
                    'genero' => $data['genero'] ?? null,
                    'regimen' => $this->replaceSpecialChars($data['regimen'] ?? null),
                    'celular' => $data['celular'] ?? null,
                    'cargo' => $this->replaceSpecialChars($data['cargo'] ?? null),
                    'direccion' => $this->replaceSpecialChars($data['direccion'] ?? null),
                    'fecha_afiliacion' => (!empty($data['fecha_afiliacion']))
                        ? Carbon::parse($data['fecha_afiliacion'])
                        : now(),
                    'documento_pdf_path' => $data['documento_pdf'] ?? null,
                    'observaciones' => $this->replaceSpecialChars($data['observaciones'] ?? null),
                    'correo' => $correo,
                    'tipo_usuario' => $data['tipo_usuario'] ?? 'adherente',
                    // aquí asignamos el cupo si existe en el mapa
                    'cupo' => $cupos[$cedula] ?? 0,
                ]
            );

            $count++;
        }

        // Limpiar archivo temporal
        if (isset($tempFile) && file_exists($tempFile)) {
            unlink($tempFile);
        }

        $this->command->info("Importación de socios completada. Registros: {$count}");
    }
}
