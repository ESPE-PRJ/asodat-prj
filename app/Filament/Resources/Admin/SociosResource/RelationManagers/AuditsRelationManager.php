<?php

namespace App\Filament\Resources\Admin\SociosResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use OwenIt\Auditing\Models\Audit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AuditsRelationManager extends RelationManager
{
    protected static string $relationship = 'audits';

    protected static ?string $title = 'Auditorías';

    protected static ?string $modelLabel = 'Auditoría';

    protected static ?string $pluralModelLabel = 'Auditorías';

    public static function canViewForRecord(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): bool
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        return $user && $user->hasAnyRole(['super_admin', 'secretaria', 'tesorero']);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Las auditorías son de solo lectura
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('event')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Usuario que hizo el cambio')
                    ->searchable()
                    ->sortable()
                    ->default('Sistema')
                    ->icon('heroicon-m-user')
                    ->iconColor('primary'),

                TextColumn::make('event')
                    ->label('Acción')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'created' => 'Creó',
                        'updated' => 'Actualizó',
                        'deleted' => 'Eliminó',
                        default => ucfirst($state),
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'created' => 'heroicon-m-plus-circle',
                        'updated' => 'heroicon-m-pencil-square',
                        'deleted' => 'heroicon-m-trash',
                        default => 'heroicon-m-document',
                    }),

                TextColumn::make('created_at')
                    ->label('Fecha y Hora')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->since()
                    ->tooltip(fn($state) => Carbon::parse($state)->format('d/m/Y H:i:s'))
                    ->icon('heroicon-m-clock'),
            ])
            ->filters([
                SelectFilter::make('event')
                    ->label('Tipo de Acción')
                    ->options([
                        'created' => 'Creado',
                        'updated' => 'Actualizado',
                        'deleted' => 'Eliminado',
                    ])
                    ->multiple()
                    ->default(['created', 'updated', 'deleted']),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('created_from')
                            ->label('Desde')
                            ->placeholder('Seleccionar fecha inicial'),
                        \Filament\Forms\Components\DatePicker::make('created_until')
                            ->label('Hasta')
                            ->placeholder('Seleccionar fecha final'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = 'Desde: ' . Carbon::parse($data['created_from'])->format('d/m/Y');
                        }
                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Hasta: ' . Carbon::parse($data['created_until'])->format('d/m/Y');
                        }
                        return $indicators;
                    }),
            ])
            ->headerActions([
                // No permitir crear auditorías manualmente
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Ver Detalles')
                    ->modalHeading('Detalles de la Auditoría')
                    ->modalContent(function (Audit $record) {
                        $socio = $this->ownerRecord; // El socio actual
                        $oldValues = $record->old_values ?? [];
                        $newValues = $record->new_values ?? [];

                        $content = '<div class="space-y-6">';

                        // Información general
                        $content .= '<div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">';
                        $content .= '<h3 class="font-semibold text-lg mb-3 text-gray-900 dark:text-white">📋 Información General</h3>';
                        $content .= '<div class="grid grid-cols-2 gap-4 text-sm">';
                        $content .= '<div><strong class="text-gray-700 dark:text-gray-300">Socio afectado:</strong><br><span class="text-gray-900 dark:text-white">' . $socio->apellidos_nombres . '</span></div>';
                        $content .= '<div><strong class="text-gray-700 dark:text-gray-300">Acción realizada:</strong><br><span class="text-gray-900 dark:text-white">' . match ($record->event) {
                            'created' => '✅ Creación de registro',
                            'updated' => '✏️ Actualización de datos',
                            'deleted' => '🗑️ Eliminación de registro',
                            default => ucfirst($record->event)
                        } . '</span></div>';
                        $content .= '<div><strong class="text-gray-700 dark:text-gray-300">Usuario:</strong><br><span class="text-gray-900 dark:text-white">' . ($record->user->name ?? 'Sistema') . '</span></div>';
                        $content .= '<div><strong class="text-gray-700 dark:text-gray-300">Fecha y hora:</strong><br><span class="text-gray-900 dark:text-white">' . $record->created_at->format('d/m/Y H:i:s') . '</span></div>';
                        if ($record->ip_address) {
                            $content .= '<div><strong class="text-gray-700 dark:text-gray-300">Dirección IP:</strong><br><span class="text-gray-900 dark:text-white">' . $record->ip_address . '</span></div>';
                        }
                        $content .= '</div>';
                        $content .= '</div>';

                        // Valores anteriores
                        if (!empty($oldValues)) {
                            $content .= '<div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-4">';
                            $content .= '<h3 class="font-semibold text-lg mb-3 text-red-700 dark:text-red-300">📝 Valores Anteriores</h3>';
                            $content .= '<div class="space-y-2 text-sm">';
                            foreach ($oldValues as $key => $value) {
                                $label = $this->getFieldLabel($key);
                                $content .= '<div class="border-l-4 border-red-300 pl-3"><strong class="text-red-700 dark:text-red-300">' . $label . ':</strong><br><span class="text-gray-900 dark:text-white">' . ($value ?: 'Vacío') . '</span></div>';
                            }
                            $content .= '</div>';
                            $content .= '</div>';
                        }

                        // Valores nuevos
                        if (!empty($newValues)) {
                            $content .= '<div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4">';
                            $content .= '<h3 class="font-semibold text-lg mb-3 text-green-700 dark:text-green-300">📝 Valores Nuevos</h3>';
                            $content .= '<div class="space-y-2 text-sm">';
                            foreach ($newValues as $key => $value) {
                                $label = $this->getFieldLabel($key);
                                $content .= '<div class="border-l-4 border-green-300 pl-3"><strong class="text-green-700 dark:text-green-300">' . $label . ':</strong><br><span class="text-gray-900 dark:text-white">' . ($value ?: 'Vacío') . '</span></div>';
                            }
                            $content .= '</div>';
                            $content .= '</div>';
                        }

                        $content .= '</div>';

                        return new \Illuminate\Support\HtmlString($content);
                    })
                    ->modalWidth('4xl'),
            ])
            ->bulkActions([
                // No permitir acciones masivas en auditorías
            ])
            ->defaultSort('created_at', 'desc');
    }

    private function getFieldLabel(string $field): string
    {
        return match ($field) {
            'cedula' => 'Cédula',
            'apellidos_nombres' => 'Apellidos y Nombres',
            'campus' => 'Campus',
            'genero' => 'Género',
            'regimen' => 'Régimen',
            'celular' => 'Celular',
            'cargo' => 'Cargo',
            'direccion' => 'Dirección',
            'fecha_afiliacion' => 'Fecha de Afiliación',
            'correo' => 'Correo Electrónico',
            'tipo_usuario' => 'Tipo de Usuario',
            'cupo' => 'Cupo',
            'observaciones' => 'Observaciones',
            'documento_pdf_path' => 'Documento PDF',
            default => ucfirst(str_replace('_', ' ', $field))
        };
    }
}
