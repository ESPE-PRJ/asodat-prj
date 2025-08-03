<?php

namespace Database\Seeders;


use App\Models\Socio;
use App\Models\Aporte;
use App\Models\TipoAporte;
use Carbon\Carbon;


use Illuminate\Database\Seeder;


class AportesCsvSeeder extends Seeder
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
        // 1) Pre-carga los tipos de aporte en memoria [clave => id]
        $definidos = [
            'nuevo_ingreso' => 'Nuevo Ingreso',
            'ordinario' => 'Aporte Ordinario',
            'extraordinario' => 'Aporte Extraordinario',
        ];
        $tipos = [];
        foreach ($definidos as $clave => $nombre) {
            $tipos[$clave] = TipoAporte::firstOrCreate(
                ['clave' => $clave],
                ['nombre' => $nombre]
            )->id;
        }

        $this->command->info("Tipos de aporte asegurados: " . implode(', ', array_keys($tipos)));

        $this->command->warn("Leyendo CSV de aportes…");
        // 2) Abre el CSV crudo
        $path = database_path('data/aportes_old.csv');

        // Ruta al CSV
        $path = database_path('data/aportes_old.csv');
        if (!file_exists($path)) {
            $this->command->error("No encontré el CSV en: $path");
            return;
        }

        $file = new \SplFileObject($path);
        $file->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );
        // Indica que el delimitador es ; y el enclosure "
        $file->setCsvControl(';', '"', '\\');

        // Leemos encabezados y los normalizamos
        $rawHeaders = $file->fgetcsv();
        $headers = array_map(function ($h) {
            $h = trim($h);
            // quita BOM si lo hubiera
            $h = preg_replace('/^\x{FEFF}/u', '', $h);
            return mb_strtolower($h);
        }, $rawHeaders);

        // 4) Mapa de columna→[tipoClave, función que genera el periodo]
        $map = [
            'nuevos_ingresos' => ['nuevo_ingreso', fn($y) => Carbon::create($y, 1, 1)],
            'dic_aa' => ['ordinario', fn($y) => Carbon::create($y - 1, 12, 1)],
            'enero' => ['ordinario', fn($y) => Carbon::create($y, 1, 1)],
            'febrero' => ['ordinario', fn($y) => Carbon::create($y, 2, 1)],
            'marzo' => ['ordinario', fn($y) => Carbon::create($y, 3, 1)],
            'abril' => ['ordinario', fn($y) => Carbon::create($y, 4, 1)],
            'mayo' => ['ordinario', fn($y) => Carbon::create($y, 5, 1)],
            'junio' => ['ordinario', fn($y) => Carbon::create($y, 6, 1)],
            'julio' => ['ordinario', fn($y) => Carbon::create($y, 7, 1)],
            'agosto' => ['ordinario', fn($y) => Carbon::create($y, 8, 1)],
            'septiembre' => ['ordinario', fn($y) => Carbon::create($y, 9, 1)],
            'octubre' => ['ordinario', fn($y) => Carbon::create($y, 10, 1)],
            'noviembre' => ['ordinario', fn($y) => Carbon::create($y, 11, 1)],
        ];
        $year = now()->year;
        $count = 0;

        // 5) Itera cada línea del CSV
        while (!$file->eof()) {
            $row = $file->fgetcsv();
            if (!is_array($row) || count($row) !== count($headers)) {
                continue;
            }
            $data = array_combine($headers, $row);

            // Sanear cédula: solo dígitos
            $cedula = preg_replace('/\D/', '', $data['cedula'] ?? '');
            if (strlen($cedula) < 5) {
                continue;
            }

            $socio = Socio::where('cedula', $cedula)->first();
            if (!$socio) {
                $this->command->warn("Socio {$cedula} no encontrado, salto fila.");
                continue;
            }

            // Por cada columna de aporte, si valor>0 insertamos/actualizamos
            foreach ($map as $col => [$tipoClave, $periodoFn]) {
                if (!isset($data[$col])) {
                    continue;
                }
                $valor = floatval(str_replace(',', '.', $data[$col]));
                if ($valor <= 0) {
                    continue;
                }

                $tipoId = $tipos[$tipoClave];

                Aporte::updateOrCreate(
                    [
                        'socio_id' => $socio->id,
                        'tipo_aporte_id' => $tipoId,
                        'periodo' => $periodoFn($year),
                    ],
                    [
                        'monto' => $valor,
                        'estado' => 'pagado',
                    ]
                );

                $count++;
            }
        }
        $this->command->info("Importación de aportes completada. Se procesaron $count filas.");
    }
}
