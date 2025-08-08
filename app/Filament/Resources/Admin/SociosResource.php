<?php

namespace App\Filament\Resources\Admin;

use App\Filament\Resources\Admin\SociosResource\Pages;
use App\Filament\Resources\Admin\SociosResource\RelationManagers;
use App\Models\Socio;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Filament\Facades\Filament;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;

class SociosResource extends Resource
{
    protected static ?string $model = Socio::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Socios';
    protected static ?string $navigationGroup = 'Administración';
    protected static ?string $modelLabel = 'Socio';
    protected static ?string $pluralModelLabel = 'Socios';

    public static function canAccess(): bool
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        return $user && $user->hasAnyRole(['super_admin', 'secretaria', 'tesorero']);
    }
    public static function canCreate(): bool
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        return $user && $user->hasAnyRole(['super_admin', 'secretaria', 'tesorero']);
    }

    public static function canEdit($record): bool
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        return $user && $user->hasAnyRole(['super_admin', 'secretaria', 'tesorero']);
    }

    public static function canDelete($record): bool
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        return $user && $user->hasAnyRole(['super_admin', 'secretaria']);
    }

    public static function canView($record): bool
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        return $user && $user->hasAnyRole(['super_admin', 'secretaria', 'tesorero']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información Personal')
                    ->schema([

                        Forms\Components\TextInput::make('apellidos')
                            ->label('Apellidos')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('nombres')
                            ->label('Nombres')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('cedula')
                            ->label('Cédula')
                            ->required()
                            ->maxLength(20)
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('correo')
                            ->label('Correo Electrónico')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('celular')
                            ->label('Celular')
                            ->tel()
                            ->maxLength(20)->helperText('Campo opcional'),

                        Forms\Components\Select::make('genero')
                            ->label('Género')
                            ->options([
                                'M' => 'Masculino',
                                'F' => 'Femenino',
                            ])->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Información de Afiliación')
                    ->schema([
                        Forms\Components\DatePicker::make('fecha_afiliacion')
                            ->label('Fecha de Afiliación')
                            ->required()
                            ->displayFormat('d/m/Y')
                            ->native(false)
                            ->default(now()),

                        Forms\Components\Select::make('campus')
                            ->label('Campus')
                            ->options([
                                'Belisario Quevedo' => 'Belisario Quevedo',
                                'Latacunga Centro' => 'Latacunga Centro',
                            ])->required(),

                        Forms\Components\Select::make('regimen')
                            ->label('Régimen')
                            ->options([
                                'pregrado' => 'Pregrado',
                                'posgrado' => 'Posgrado',
                                'administrativo' => 'Administrativo',
                                'docente' => 'Docente',
                            ])->required(),

                        Forms\Components\TextInput::make('cargo')
                            ->label('Cargo')
                            ->maxLength(100)->required(),

                        Forms\Components\TextInput::make('cupo')
                            ->label('Cupo')
                            ->numeric()
                            ->minValue(0)
                            ->helperText('Campo opcional'),

                        Forms\Components\Select::make('tipo_usuario')
                            ->label('Tipo de Usuario')
                            ->options([
                                'adherente' => 'Adherente',
                                'fundador' => 'Fundador',
                            ])
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Información de Usuario')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label('Contraseña')
                            ->password()
                            ->required(fn(string $context): bool => $context === 'create')
                            ->minLength(8)
                            ->confirmed(),

                        Forms\Components\TextInput::make('password_confirmation')
                            ->label('Confirmar Contraseña')
                            ->password()
                            ->required(fn(string $context): bool => $context === 'create')
                            ->minLength(8),

                        Forms\Components\Select::make('roles')
                            ->label('Roles')
                            ->multiple()
                            ->options(Role::pluck('name', 'name'))
                            ->default(['socio'])
                            ->required()
                            ->preload(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Información Adicional')
                    ->schema([
                        Forms\Components\Textarea::make('direccion')
                            ->label('Dirección')
                            ->maxLength(500)
                            ->columnSpanFull()
                            ->required(),

                        Forms\Components\Textarea::make('observaciones')
                            ->label('Observaciones')
                            ->maxLength(1000)
                            ->columnSpanFull()
                            ->helperText('Campo opcional'),

                        Forms\Components\FileUpload::make('documento_pdf_path')
                            ->label('Documento PDF')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('documentos-socios')
                            ->columnSpanFull()
                            ->helperText('Campo opcional (solo archivos PDF)'),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Información Personal')
                    ->schema([
                        Infolists\Components\TextEntry::make('cedula')
                            ->label('Cédula')
                            ->weight('bold')
                            ->formatStateUsing(fn($state) => !empty($state) ? $state : 'sin datos'),

                        Infolists\Components\TextEntry::make('apellidos_nombres')
                            ->label('Apellidos y Nombres')
                            ->weight('bold')
                            ->formatStateUsing(fn($state) => !empty($state) ? $state : 'sin datos'),

                        Infolists\Components\TextEntry::make('correo')
                            ->label('Correo Electrónico')
                            ->weight('bold')
                            ->formatStateUsing(fn($state) => !empty($state) ? $state : 'sin datos'),

                        Infolists\Components\TextEntry::make('celular')
                            ->label('Celular')
                            ->weight('bold')
                            ->formatStateUsing(fn($state) => !empty($state) ? $state : 'sin datos'),

                        Infolists\Components\TextEntry::make('genero')
                            ->label('Género')
                            ->weight('bold')
                            ->formatStateUsing(fn($state) => match ($state) {
                                'M' => 'Masculino',
                                'F' => 'Femenino',
                                default => 'sin datos',
                            }),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Información de Afiliación')
                    ->schema([
                        Infolists\Components\TextEntry::make('fecha_afiliacion')
                            ->label('Fecha de Afiliación')
                            ->weight('bold')
                            ->date('d/m/Y')
                            ->formatStateUsing(fn($state) => !empty($state) ? Carbon::parse($state)->format('d/m/Y') : 'sin datos'),

                        Infolists\Components\TextEntry::make('campus')
                            ->label('Campus')
                            ->weight('bold')
                            ->formatStateUsing(fn($state) => !empty($state) ? $state : 'sin datos'),

                        Infolists\Components\TextEntry::make('regimen')
                            ->label('Régimen')
                            ->weight('bold'),

                        Infolists\Components\TextEntry::make('cargo')
                            ->label('Cargo')
                            ->weight('bold')
                            ->formatStateUsing(fn($state) => !empty($state) ? $state : 'sin datos'),

                        Infolists\Components\TextEntry::make('cupo')
                            ->label('Cupo')
                            ->weight('bold')
                            ->formatStateUsing(fn($state) => !empty($state) ? $state : 'sin datos'),

                        Infolists\Components\TextEntry::make('tipo_usuario')
                            ->label('Tipo de Usuario')
                            ->weight('bold')
                            ->formatStateUsing(fn($state) => !empty($state) ? $state : 'sin datos'),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Información de Usuario')
                    ->schema([
                        Infolists\Components\TextEntry::make('user.name')
                            ->label('Nombre de Usuario')
                            ->weight('bold')
                            ->formatStateUsing(fn($state) => !empty($state) ? $state : 'sin datos'),

                        Infolists\Components\TextEntry::make('user.email')
                            ->label('Email de Usuario')
                            ->weight('bold')
                            ->formatStateUsing(fn($state) => !empty($state) ? $state : 'sin datos'),

                        Infolists\Components\TextEntry::make('user.roles')
                            ->label('Roles Asignados')
                            ->weight('bold')
                            ->formatStateUsing(function ($record) {
                                // Acceder directamente al usuario asociado al socio
                                $user = User::where('socio_id', $record->id)->first();
                                if (!$user) {
                                    return 'sin datos';
                                }

                                $roles = $user->roles;
                                if (!$roles || $roles->isEmpty()) {
                                    return 'sin datos';
                                }

                                return $roles->pluck('name')->implode(', ');
                            })
                            ->badge(),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Información Adicional')
                    ->schema([
                        Infolists\Components\TextEntry::make('direccion')
                            ->label('Dirección')
                            ->weight('bold')
                            ->formatStateUsing(fn($state) => !empty($state) ? $state : 'sin datos')
                            ->columnSpanFull(),

                        Infolists\Components\TextEntry::make('observaciones')
                            ->label('Observaciones')
                            ->weight('bold')
                            ->formatStateUsing(fn($state) => !empty($state) ? $state : 'sin datos')
                            ->columnSpanFull(),

                        Infolists\Components\TextEntry::make('documento_pdf_path')
                            ->label('Documento PDF')
                            ->weight('bold')
                            ->formatStateUsing(fn($state) => !empty($state) ? 'Documento cargado' : 'sin datos')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('apellidos_nombres')
                    ->label('Nombre Completo')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('correo')
                    ->label('Correo')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('cedula')
                    ->label('Cédula')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('fecha_afiliacion')
                    ->label('Fecha de Afiliación')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.roles')
                    ->label('Roles')
                    ->formatStateUsing(function ($record) {
                        $user = User::where('socio_id', $record->id)->first();
                        if (!$user) {
                            return 'sin datos';
                        }

                        $roles = $user->roles;
                        if (!$roles || $roles->isEmpty()) {
                            return 'sin datos';
                        }

                        return $roles->pluck('name')->implode(', ');
                    })
                    ->badge(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Registro')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        'activo' => 'Activo',
                        'inactivo' => 'Inactivo',
                        'suspendido' => 'Suspendido',
                    ]),

                Tables\Filters\SelectFilter::make('regimen')
                    ->label('Régimen'),

                Tables\Filters\SelectFilter::make('roles')
                    ->label('Roles')
                    ->relationship('user.roles', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('exportPdf')
                    ->label('Descargar Lista PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->action(function () {
                        return self::generateSociosPdf();
                    }),
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
            'index' => Pages\ListSocios::route('/'),
            'create' => Pages\CreateSocios::route('/create'),
            'view' => Pages\ViewSocios::route('/{record}'),
            'edit' => Pages\EditSocios::route('/{record}/edit'),
        ];
    }

    public static function generateSociosPdf()
    {
        $socios = Socio::with('user.roles')
            ->orderBy('apellidos_nombres')
            ->get();

        $pdf = Pdf::loadView('pdf.lista-socios', compact('socios'));

        $filename = 'lista-socios-' . date('Y-m-d') . '.pdf';

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
