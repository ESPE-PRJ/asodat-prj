<?php

namespace App\Filament\Resources\Admin;

use App\Filament\Resources\Admin\SociosResource\Pages;
use App\Filament\Resources\Admin\SociosResource\RelationManagers;
use App\Models\Admin\Socios;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SociosResource extends Resource
{
    protected static ?string $model = Socios::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'edit' => Pages\EditSocios::route('/{record}/edit'),
        ];
    }
}
