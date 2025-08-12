<?php

namespace App\Filament\Resources\Admin\AporteResource\Pages;

use App\Filament\Resources\Admin\AporteResource;
use App\Imports\AportesImport;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;

class ListAportes extends ListRecords
{
    protected static string $resource = AporteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Actions\Action::make('descargar_ejemplo')
                ->label('Descargar Ejemplo CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->url('/ejemplos/aportes_ejemplo.csv')
                ->openUrlInNewTab(),

            Actions\Action::make('importar_csv')
                ->label('Importar CSV')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('success')
                ->form([
                    FileUpload::make('archivo_csv')
                        ->label('Archivo CSV')
                        ->acceptedFileTypes(['text/csv', '.csv'])
                        ->required()
                        ->helperText('El archivo debe contener las columnas: cedula, tipo_aporte, periodo, monto, estado (opcional). Puedes descargar un archivo de ejemplo desde el botón "Descargar Ejemplo CSV".')
                        ->columnSpanFull(),
                ])
                ->action(function (array $data) {
                    $this->importarAportes($data['archivo_csv']);
                })
                ->modalHeading('Importar Aportes desde CSV')
                ->modalDescription('
                    Sube un archivo CSV con los datos de los aportes. El formato debe incluir las columnas: 
                    cedula, tipo_aporte, periodo, monto y estado (opcional).
                    
                    Formatos de fecha aceptados para el campo "periodo":
                    - YYYY-MM-DD (2024-01-01)
                    - DD/MM/YYYY (01/01/2024)  
                    - MM/YYYY (01/2024)
                    - YYYY-MM (2024-01)
                ')
                ->modalSubmitActionLabel('Importar')
                ->modalCancelActionLabel('Cancelar'),
        ];
    }

    private function importarAportes($archivo)
    {
        try {
            // Obtener la ruta real del archivo
            $filePath = Storage::disk('public')->path($archivo);

            if (!file_exists($filePath)) {
                Notification::make()
                    ->title('Error')
                    ->body('El archivo no se pudo encontrar.')
                    ->danger()
                    ->send();
                return;
            }

            // Crear instancia del importador
            $importer = new AportesImport();
            $result = $importer->import($filePath);

            if ($result['success']) {
                $mensaje = "Importación completada. {$result['processed']} aportes procesados correctamente.";

                if (count($result['errors']) > 0) {
                    $mensaje .= " Se encontraron " . count($result['errors']) . " errores.";
                }

                Notification::make()
                    ->title('Importación Exitosa')
                    ->body($mensaje)
                    ->success()
                    ->send();

                // Si hay errores, mostrarlos en una notificación adicional
                if (count($result['errors']) > 0) {
                    $erroresTexto = implode("\n", array_slice($result['errors'], 0, 5));
                    if (count($result['errors']) > 5) {
                        $erroresTexto .= "\n... y " . (count($result['errors']) - 5) . " errores más.";
                    }

                    Notification::make()
                        ->title('Errores encontrados')
                        ->body($erroresTexto)
                        ->warning()
                        ->duration(10000)
                        ->send();
                }
            } else {
                Notification::make()
                    ->title('Error en la Importación')
                    ->body($result['error'] ?? 'Error desconocido')
                    ->danger()
                    ->send();
            }

            // Limpiar el archivo temporal
            Storage::disk('public')->delete($archivo);
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error')
                ->body('Error inesperado: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }
}
