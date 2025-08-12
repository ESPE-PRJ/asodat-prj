<?php

namespace App\Filament\Resources\Admin\SociosResource\Pages;

use App\Filament\Resources\Admin\SociosResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;

class ViewSocios extends ViewRecord
{
    protected static string $resource = SociosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('audits')
                ->label('Ver Auditorías')
                ->icon('heroicon-o-document-text')
                ->color('info')
                ->url('/sys/auditorias-socios')
                ->visible(function () {
                    /** @var \App\Models\User */
                    $user = Auth::user();
                    return $user && $user->hasAnyRole(['super_admin', 'secretaria', 'tesorero']);
                }),
        ];
    }
}
