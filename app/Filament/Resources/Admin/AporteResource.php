<?php

namespace App\Filament\Resources\Admin;

use App\Filament\Resources\Admin\AporteResource\Pages;
use App\Filament\Resources\Admin\AporteResource\RelationManagers;
use App\Models\Aporte;
use App\Models\Socio;
use App\Models\TipoAporte;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Grid;

class AporteResource extends Resource
{
    protected static ?string $model = Aporte::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Aportes';

    protected static ?string $modelLabel = 'Aporte';

    protected static ?string $pluralModelLabel = 'Aportes';

    protected static ?string $navigationGroup = 'Administración';

    public static function canAccess(): bool
    {
        $user = auth()->user();
        return $user && $user->hasAnyRole(['super_admin']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información del Aporte')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('socio_id')
                                    ->label('Socio')
                                    ->options(function () {
                                        return Socio::orderBy('apellidos_nombres')->pluck('apellidos_nombres', 'id');
                                    })
                                    ->searchable()
                                    ->required()
                                    ->placeholder('Seleccione un socio')
                                    ->live()
                                    ->afterStateUpdated(fn($state, callable $set) => $set('socio_id', $state)),

                                Select::make('tipo_aporte_id')
                                    ->label('Tipo de Aporte')
                                    ->options(function () {
                                        return TipoAporte::orderBy('nombre')->pluck('nombre', 'id');
                                    })
                                    ->searchable()
                                    ->required()
                                    ->placeholder('Seleccione el tipo de aporte'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                DatePicker::make('periodo')
                                    ->label('Período')
                                    ->required()
                                    ->displayFormat('d/m/Y')
                                    ->native(false)
                                    ->default(now()),

                                TextInput::make('monto')
                                    ->label('Monto')
                                    ->numeric()
                                    ->required()
                                    ->prefix('$')
                                    ->minValue(0)
                                    ->step(0.01)
                                    ->formatStateUsing(fn($state) => $state ? number_format($state, 2) : '')
                                    ->dehydrateStateUsing(fn($state) => $state ? (float) str_replace(',', '', $state) : null),
                            ]),

                        Select::make('estado')
                            ->label('Estado')
                            ->options(Aporte::getEstados())
                            ->default(Aporte::ESTADO_PENDIENTE)
                            ->required()
                            ->placeholder('Seleccione el estado'),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('socio.apellidos_nombres')
                    ->label('Socio')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('tipoAporte.nombre')
                    ->label('Tipo de Aporte')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('periodo')
                    ->label('Período')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('monto')
                    ->label('Monto')
                    ->money('USD')
                    ->sortable()
                    ->alignRight(),

                BadgeColumn::make('estado')
                    ->label('Estado')
                    ->colors([
                        'warning' => Aporte::ESTADO_PENDIENTE,
                        'success' => Aporte::ESTADO_PAGADO,
                        'danger' => Aporte::ESTADO_VENCIDO,
                    ])
                    ->formatStateUsing(fn(string $state): string => Aporte::getEstados()[$state] ?? $state),

                TextColumn::make('created_at')
                    ->label('Fecha de Creación')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('estado')
                    ->label('Estado')
                    ->options(Aporte::getEstados()),

                SelectFilter::make('tipo_aporte_id')
                    ->label('Tipo de Aporte')
                    ->options(function () {
                        return TipoAporte::orderBy('nombre')->pluck('nombre', 'id');
                    })
                    ->searchable(),

                Filter::make('periodo')
                    ->form([
                        DatePicker::make('periodo_desde')
                            ->label('Desde'),
                        DatePicker::make('periodo_hasta')
                            ->label('Hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['periodo_desde'],
                                fn(Builder $query, $date): Builder => $query->whereDate('periodo', '>=', $date),
                            )
                            ->when(
                                $data['periodo_hasta'],
                                fn(Builder $query, $date): Builder => $query->whereDate('periodo', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAportes::route('/'),
            'create' => Pages\CreateAporte::route('/create'),
            'view' => Pages\ViewAporte::route('/{record}'),
            'edit' => Pages\EditAporte::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['socio', 'tipoAporte']);
    }
}
