<?php

namespace App\Filament\Resources\Socio;

use App\Filament\Resources\Socio\AporteResource\Pages;
use App\Filament\Resources\Socio\AporteResource\RelationManagers;
use App\Models\Aporte;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class AporteResource extends Resource
{
    protected static ?string $model = Aporte::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'Histórico';
    protected static ?string $navigationGroup = 'Afiliación';
    protected static ?string $modelLabel = 'Aporte';
    protected static ?string $pluralModelLabel = 'Aportes';

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && $user->hasRole('socio') && $user->socio;
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        $socio = $user->socio;

        if (!$socio) {
            return Aporte::query()->where('id', 0); // Query que no retorna resultados
        }

        return Aporte::query()
            ->where('socio_id', $socio->id)
            ->with(['tipoAporte']);
    }

    public static function form(Form $form): Form
    {
        $user = Auth::user();
        $socio = $user->socio;

        return $form
            ->schema([
                Forms\Components\Section::make('Información del Aporte')
                    ->schema([
                        Forms\Components\Select::make('tipo_aporte_id')
                            ->label('Tipo de Aporte')
                            ->relationship('tipoAporte', 'nombre')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\DatePicker::make('periodo')
                            ->label('Período')
                            ->required()
                            ->displayFormat('d/m/Y')
                            ->native(false),

                        Forms\Components\TextInput::make('monto')
                            ->label('Monto')
                            ->numeric()
                            ->required()
                            ->prefix('$')
                            ->minValue(0)
                            ->step(0.01)
                            ->formatStateUsing(fn($state) => $state ? number_format($state, 2) : '')
                            ->dehydrateStateUsing(fn($state) => $state ? (float) str_replace(',', '', $state) : null),

                        Forms\Components\Select::make('estado')
                            ->label('Estado')
                            ->options([
                                'pendiente' => 'Pendiente',
                                'pagado' => 'Pagado',
                                'vencido' => 'Vencido',
                            ])
                            ->required()
                            ->default('pendiente'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tipoAporte.nombre')
                    ->label('Tipo de Aporte')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('periodo')
                    ->label('Período')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('monto')
                    ->label('Monto')
                    ->money('USD')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('estado')
                    ->label('Estado')
                    ->colors([
                        'warning' => 'pendiente',
                        'success' => 'pagado',
                        'danger' => 'vencido',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Registro')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'pagado' => 'Pagado',
                        'vencido' => 'Vencido',
                    ]),

                Tables\Filters\SelectFilter::make('tipo_aporte_id')
                    ->label('Tipo de Aporte')
                    ->relationship('tipoAporte', 'nombre'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->visible(fn(Aporte $record) => $record->estado !== 'pagado' && $record->estado !== 'verificado'),
                Tables\Actions\EditAction::make()
                    ->visible(fn(Aporte $record) => $record->estado !== 'pagado' && $record->estado !== 'verificado'),
            ])
            ->bulkActions([
                // No bulk actions for socio
            ])
            ->defaultSort('created_at', 'desc');
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
            'edit' => Pages\EditAporte::route('/{record}/edit'),
        ];
    }
}
