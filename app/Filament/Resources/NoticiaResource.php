<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NoticiaResource\Pages;
use App\Filament\Resources\NoticiaResource\RelationManagers;
use App\Models\Noticia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class NoticiaResource extends Resource
{
    protected static ?string $model = Noticia::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'Noticias';
    protected static ?string $navigationGroup = 'Gestión de Contenido';
    protected static ?string $modelLabel = 'Noticia';
    protected static ?string $pluralModelLabel = 'Noticias';

    public static function canAccess(): bool
    {
        $user = \Filament\Facades\Filament::auth()->user();
        return $user && in_array($user->rol, ['administrador', 'presidente']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información Principal')
                    ->schema([
                        Forms\Components\TextInput::make('titulo')
                            ->label('Título')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\Select::make('categoria')
                            ->label('Categoría')
                            ->options([
                                'general' => 'General',
                                'evento' => 'Evento',
                                'comunicado' => 'Comunicado',
                                'aviso' => 'Aviso',
                                'reunion' => 'Reunión',
                            ])
                            ->required()
                            ->default('general'),

                        Forms\Components\FileUpload::make('imagen_path')
                            ->label('Imagen')
                            ->directory('noticias')
                            ->image()
                            ->imageEditor()
                            ->maxSize(2048)
                            ->helperText('Tamaño máximo: 2MB. Formatos: JPG, PNG'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Contenido')
                    ->schema([
                        Forms\Components\RichEditor::make('contenido')
                            ->label('Contenido de la Noticia')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'bulletList',
                                'orderedList',
                                'link',
                                'blockquote',
                                'h2',
                                'h3',
                            ]),
                    ]),

                Forms\Components\Section::make('Programación de Publicación')
                    ->schema([
                        Forms\Components\DateTimePicker::make('publicar_desde')
                            ->label('Publicar Desde')
                            ->required()
                            ->default(now())
                            ->native(false),

                        Forms\Components\DateTimePicker::make('publicar_hasta')
                            ->label('Publicar Hasta')
                            ->after('publicar_desde')
                            ->native(false)
                            ->helperText('Opcional. Dejar vacío para publicación indefinida'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('imagen_path')
                    ->label('Imagen')
                    ->square()
                    ->size(60),

                Tables\Columns\TextColumn::make('titulo')
                    ->label('Título')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                Tables\Columns\BadgeColumn::make('categoria')
                    ->label('Categoría')
                    ->colors([
                        'primary' => 'general',
                        'success' => 'evento',
                        'warning' => 'comunicado',
                        'danger' => 'aviso',
                        'info' => 'reunion',
                    ])
                    ->searchable(),

                Tables\Columns\TextColumn::make('publicar_desde')
                    ->label('Publicar Desde')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('publicar_hasta')
                    ->label('Publicar Hasta')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Sin límite'),

                Tables\Columns\IconColumn::make('activa')
                    ->label('Estado')
                    ->boolean()
                    ->state(function (Noticia $record) {
                        $now = now();
                        $desde = $record->publicar_desde;
                        $hasta = $record->publicar_hasta;

                        return $now >= $desde && ($hasta === null || $now <= $hasta);
                    })
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('categoria')
                    ->label('Categoría')
                    ->options([
                        'general' => 'General',
                        'evento' => 'Evento',
                        'comunicado' => 'Comunicado',
                        'aviso' => 'Aviso',
                        'reunion' => 'Reunión',
                    ]),
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
            'index' => Pages\ListNoticias::route('/'),
            'create' => Pages\CreateNoticia::route('/create'),
            'view' => Pages\ViewNoticia::route('/{record}'),
            'edit' => Pages\EditNoticia::route('/{record}/edit'),
        ];
    }
}
