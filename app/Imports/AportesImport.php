<?php

namespace App\Imports;

use App\Models\Aporte;
use App\Models\Socio;
use App\Models\TipoAporte;
use Carbon\Carbon;
use Exception;

class AportesImport
{
    private $errors = [];
    private $successCount = 0;

    public function import($filePath)
    {
        try {
            $handle = fopen($filePath, 'r');
            if (!$handle) {
                throw new Exception('No se pudo abrir el archivo CSV');
            }

            // Detectar el separador CSV
            $firstLine = fgets($handle);
            rewind($handle);

            $separator = ',';
            if ($firstLine && substr_count($firstLine, ';') > substr_count($firstLine, ',')) {
                $separator = ';';
            }

            // Leer la primera línea como encabezados
            $headers = fgetcsv($handle, 1000, $separator);
            if (!$headers) {
                throw new Exception('El archivo CSV está vacío o no tiene encabezados válidos');
            }

            // Normalizar encabezados
            $headers = array_map(function ($header) {
                return strtolower(trim($header));
            }, $headers);

            // Verificar que existan las columnas requeridas
            $requiredColumns = ['cedula', 'tipo_aporte', 'periodo', 'monto'];
            foreach ($requiredColumns as $required) {
                if (!in_array($required, $headers)) {
                    throw new Exception("Columna requerida '{$required}' no encontrada en el CSV");
                }
            }

            $lineNumber = 1;

            // Procesar cada línea
            while (($data = fgetcsv($handle, 1000, $separator)) !== false) {
                $lineNumber++;

                if (count($data) !== count($headers)) {
                    $this->errors[] = "Línea {$lineNumber}: Número incorrecto de columnas";
                    continue;
                }

                $row = array_combine($headers, $data);
                $this->processRow($row, $lineNumber);
            }

            fclose($handle);

            return [
                'success' => true,
                'processed' => $this->successCount,
                'errors' => $this->errors
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'processed' => $this->successCount,
                'errors' => $this->errors
            ];
        }
    }

    private function processRow($row, $lineNumber)
    {
        try {
            // Limpiar y validar cédula
            $cedula = preg_replace('/\D/', '', $row['cedula'] ?? '');
            if (strlen($cedula) < 5) {
                $this->errors[] = "Línea {$lineNumber}: Cédula inválida '{$row['cedula']}'";
                return;
            }

            // Buscar el socio
            $socio = Socio::where('cedula', $cedula)->first();
            if (!$socio) {
                $this->errors[] = "Línea {$lineNumber}: Socio con cédula {$cedula} no encontrado";
                return;
            }

            // Buscar o crear el tipo de aporte
            $tipoAporteNombre = trim($row['tipo_aporte'] ?? '');
            if (empty($tipoAporteNombre)) {
                $this->errors[] = "Línea {$lineNumber}: Tipo de aporte requerido";
                return;
            }

            $tipoAporte = TipoAporte::where('nombre', 'LIKE', "%{$tipoAporteNombre}%")
                ->orWhere('clave', 'LIKE', "%{$tipoAporteNombre}%")
                ->first();

            if (!$tipoAporte) {
                // Crear el tipo de aporte si no existe
                $clave = strtolower(str_replace(' ', '_', $tipoAporteNombre));
                $tipoAporte = TipoAporte::create([
                    'clave' => $clave,
                    'nombre' => $tipoAporteNombre,
                    'descripcion' => "Tipo de aporte creado automáticamente desde importación"
                ]);
            }

            // Procesar el período
            $periodoStr = trim($row['periodo'] ?? '');
            if (empty($periodoStr)) {
                $this->errors[] = "Línea {$lineNumber}: Período requerido";
                return;
            }

            $periodo = $this->parsePeriodo($periodoStr);
            if (!$periodo) {
                $this->errors[] = "Línea {$lineNumber}: Formato de período inválido '{$periodoStr}'";
                return;
            }

            // Procesar el monto
            $monto = $this->parseMonto($row['monto'] ?? '');
            if ($monto <= 0) {
                $this->errors[] = "Línea {$lineNumber}: Monto inválido '{$row['monto']}'";
                return;
            }

            // Procesar el estado (opcional)
            $estado = strtolower(trim($row['estado'] ?? 'pendiente'));
            $estadosValidos = ['pendiente', 'pagado', 'vencido'];
            if (!in_array($estado, $estadosValidos)) {
                $estado = 'pendiente';
            }

            // Crear o actualizar el aporte
            $aporte = Aporte::updateOrCreate(
                [
                    'socio_id' => $socio->id,
                    'tipo_aporte_id' => $tipoAporte->id,
                    'periodo' => $periodo,
                ],
                [
                    'monto' => $monto,
                    'estado' => $estado,
                ]
            );

            $this->successCount++;
        } catch (Exception $e) {
            $this->errors[] = "Línea {$lineNumber}: Error procesando - " . $e->getMessage();
        }
    }

    private function parsePeriodo($periodoStr)
    {
        try {
            // Intentar diferentes formatos
            $formatos = [
                'Y-m-d',
                'd/m/Y',
                'm/Y',
                'Y-m',
                'd-m-Y',
                'Y/m/d',
            ];

            foreach ($formatos as $formato) {
                try {
                    $fecha = Carbon::createFromFormat($formato, $periodoStr);
                    if ($fecha) {
                        return $fecha->startOfMonth();
                    }
                } catch (Exception $e) {
                    continue;
                }
            }

            // Si ningún formato funciona, intentar parsing automático
            return Carbon::parse($periodoStr)->startOfMonth();
        } catch (Exception $e) {
            return null;
        }
    }

    private function parseMonto($montoStr)
    {
        // Limpiar el string del monto
        $monto = trim($montoStr);
        $monto = str_replace(['$', ',', ' '], '', $monto);
        $monto = str_replace(',', '.', $monto);

        return floatval($monto);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getSuccessCount(): int
    {
        return $this->successCount;
    }
}
