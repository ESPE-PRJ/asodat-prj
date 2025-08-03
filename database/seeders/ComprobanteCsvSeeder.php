<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Socio;
use App\Models\Aporte;
use App\Models\Comprobante;
use App\Models\ComprobanteDetalle;
use SplFileObject;

class ComprobanteCsvSeeder extends Seeder
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
        $this->command->info('→ Importando comprobantes desde CSV…');

        $path = database_path('data/comprobantesdepago_old.csv');
        if (!file_exists($path)) {
            $this->command->error("No encontré: {$path}");
            return;
        }

        // 1) Abrir CSV con separador ;
        $file = new SplFileObject($path);
        $file->setFlags(
            SplFileObject::READ_CSV
            | SplFileObject::SKIP_EMPTY
            | SplFileObject::DROP_NEW_LINE
        );
        $file->setCsvControl(';', '"', '\\');

        // 2) Leer y normalizar encabezados
        $rawHdr = $file->fgetcsv();
        $headers = array_map(fn($h) => trim(strtolower($h)), $rawHdr);

        // 3) Mapa de códigos de mes → función que devuelve Carbon del período
        $periodMap = [
            'dic_aa' => fn($y) => Carbon::create($y - 1, 12, 1),
            'enero' => fn($y) => Carbon::create($y, 1, 1),
            'febrero' => fn($y) => Carbon::create($y, 2, 1),
            'marzo' => fn($y) => Carbon::create($y, 3, 1),
            'abril' => fn($y) => Carbon::create($y, 4, 1),
            'mayo' => fn($y) => Carbon::create($y, 5, 1),
            'junio' => fn($y) => Carbon::create($y, 6, 1),
            'julio' => fn($y) => Carbon::create($y, 7, 1),
            'agosto' => fn($y) => Carbon::create($y, 8, 1),
            'septiembre' => fn($y) => Carbon::create($y, 9, 1),
            'octubre' => fn($y) => Carbon::create($y, 10, 1),
            'noviembre' => fn($y) => Carbon::create($y, 11, 1),
            'nuevos_ingresos' => fn($y) => Carbon::create($y, 1, 1),
        ];
        $year = now()->year;

        $compCount = 0;
        $detalleCount = 0;

        // 4) Iterar filas
        while (!$file->eof()) {
            $row = $file->fgetcsv();
            // saltar filas vacías o mal formateadas
            if (!is_array($row) || count($row) !== count($headers)) {
                continue;
            }

            $data = array_combine($headers, $row);

            // 5) Busca socio
            $cedula = preg_replace('/\D/', '', $data['cedula'] ?? '');
            if (!$cedula) {
                $this->command->warn('→ Fila sin cédula, salto.');
                continue;
            }
            $socio = Socio::where('cedula', $cedula)->first();
            if (!$socio) {
                $this->command->warn("→ Socio {$cedula} no existe, salto.");
                continue;
            }

            // 6) Crea/actualiza Comprobante
            $ref = $this->replaceSpecialChars(trim($data['numero_comprobante'] ?? ''));
            $total = floatval($data['total'] ?? 0);
            $obs = $this->replaceSpecialChars(trim($data['observaciones'] ?? ''));
            $metodo = 'efectivo'; // o podrías mapear otro campo

            $comprobante = Comprobante::updateOrCreate(
                [
                    'socio_id' => $socio->id,
                    'referencia_pago' => $ref,
                ],
                [
                    'total' => $total,
                    'metodo_pago' => $metodo,
                    'observaciones' => $obs !== '' ? $obs : null,
                ]
            );

            $compCount++;

            // 7) Para cada detalle posible (meses_vencidos / meses_adelantados)
            $ingreso = floatval($data['ingreso'] ?? 0);
            foreach (['meses_vencidos', 'meses_adelantados'] as $field) {
                $raw = trim($data[$field] ?? '');
                if ($raw === '' || $ingreso <= 0) {
                    continue;
                }

                // 1) Separa por comas y normaliza
                $codes = array_filter(array_map(fn($c) => strtolower(trim($c)), explode(',', $raw)));

                // 2) Si quieres repartir el ingreso, descomenta:
                // $perDetalle = $ingreso / count($codes);

                foreach ($codes as $code) {
                    if (!isset($periodMap[$code])) {
                        $this->command->warn("⚠️ Código “{$code}” no reconocido, salto.");
                        continue;
                    }

                    $periodo = $periodMap[$code]($year)->startOfMonth();

                    $aporte = Aporte::where('socio_id', $socio->id)
                        ->where('periodo', $periodo)
                        ->first();

                    if (!$aporte) {
                        $this->command->warn("→ No hallé aporte para {$cedula} período {$periodo->toDateString()}.");
                        continue;
                    }

                    ComprobanteDetalle::updateOrCreate(
                        [
                            'comprobante_id' => $comprobante->id,
                            'aporte_id' => $aporte->id,
                        ],
                        [
                            // usa $perDetalle si repartes, o $ingreso si no
                            'monto_aplicado' => $ingreso,
                        ]
                    );

                    $detalleCount++;
                }
            }

        }

        $this->command->info("{$compCount} comprobantes importados.");
        $this->command->info("{$detalleCount} detalles importados.");
    }
}
