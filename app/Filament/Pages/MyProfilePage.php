<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use App\Models\User;

class MyProfilePage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel = 'Mi Perfil';
    protected static ?string $title = 'Mi Perfil';
    protected static string $view = 'filament.pages.my-profile-page';
    protected static ?string $slug = 'mi-perfil';
    protected static ?string $navigationGroup = 'Perfil';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->getFormData());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información de Usuario')
                    ->description('Datos básicos de tu cuenta de usuario')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),

                    ]),

                Section::make('Información Personal')
                    ->description('Datos personales y de afiliación')
                    ->schema($this->getSocioFormSchema())
                    ->visible(fn() => Auth::user()?->socio !== null),
            ])
            ->statePath('data');
    }

    protected function getSocioFormSchema(): array
    {
        return [
            // Campos de solo lectura (información del sistema)
            Section::make('Información del Sistema')
                ->description('Datos del sistema que no se pueden modificar')
                ->schema([
                    TextInput::make('socio.cedula')
                        ->label('Cédula')
                        ->disabled()
                        ->dehydrated(false),

                    DatePicker::make('socio.fecha_afiliacion')
                        ->label('Fecha de Afiliación')
                        ->disabled()
                        ->dehydrated(false),

                    TextInput::make('socio.cupo')
                        ->label('Cupo')
                        ->numeric()
                        ->disabled()
                        ->dehydrated(false),
                ])
                ->collapsible()
                ->collapsed(),

            // Campos editables - Información personal
            Section::make('Información Personal')
                ->description('Datos personales que puedes actualizar')
                ->schema([
                    TextInput::make('socio.apellidos_nombres')
                        ->label('Apellidos y Nombres')
                        ->required()
                        ->maxLength(255),

                    Select::make('socio.genero')
                        ->label('Género')
                        ->options([
                            'M' => 'Masculino',
                            'F' => 'Femenino',
                        ])
                        ->required(),

                    TextInput::make('socio.celular')
                        ->label('Celular')
                        ->tel()
                        ->maxLength(20),

                    Textarea::make('socio.direccion')
                        ->label('Dirección')
                        ->rows(3)
                        ->maxLength(500),

                    TextInput::make('socio.correo')
                        ->label('Correo Personal')
                        ->email()
                        ->maxLength(255),
                ]),

            // Campos editables - Información laboral
            Section::make('Información Laboral')
                ->description('Datos relacionados con tu trabajo en la institución')
                ->schema([
                    Select::make('socio.campus')
                        ->label('Campus')
                        ->options([
                            'Matriz Sangolquí' => 'Matriz Sangolquí',
                            'Sede Latacunga' => 'Sede Latacunga',
                            'IASA' => 'IASA',
                            'Héroes del Cenepa' => 'Héroes del Cenepa',
                        ])
                        ->required(),

                    Select::make('socio.regimen')
                        ->label('Régimen')
                        ->options([
                            'Tiempo Completo' => 'Tiempo Completo',
                            'Tiempo Parcial' => 'Tiempo Parcial',
                            'Contrato' => 'Contrato',
                        ])
                        ->required(),

                    TextInput::make('socio.cargo')
                        ->label('Cargo')
                        ->maxLength(255),

                    Select::make('socio.tipo_usuario')
                        ->label('Tipo de Usuario')
                        ->options([
                            'Docente' => 'Docente',
                            'Administrativo' => 'Administrativo',
                            'Trabajador' => 'Trabajador',
                        ])
                        ->required(),
                ]),

            // Campos de documentos y observaciones
            Section::make('Documentos y Observaciones')
                ->description('Información adicional y documentos')
                ->schema([
                    FileUpload::make('socio.documento_pdf_path')
                        ->label('Documento PDF')
                        ->acceptedFileTypes(['application/pdf'])
                        ->disk('public')
                        ->directory('documentos-socios')
                        ->maxSize(5120) // 5MB
                        ->downloadable()
                        ->previewable(),

                    Textarea::make('socio.observaciones')
                        ->label('Observaciones')
                        ->rows(3)
                        ->maxLength(1000)
                        ->helperText('Cualquier información adicional que consideres relevante'),
                ])
                ->collapsible(),
        ];
    }

    protected function getFormData(): array
    {
        $user = Auth::user();
        $data = [
            'name' => $user->name,
            'email' => $user->email,
        ];

        if ($user && $user->socio) {
            $data['socio'] = $user->socio->toArray();
        }

        return $data;
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Guardar Cambios')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $user = Auth::user();

        // Actualizar datos del usuario
        User::where('id', $user->id)->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        // Actualizar datos del socio si existen
        if ($user->socio && isset($data['socio'])) {
            $socioData = $data['socio'];

            // Remover solo los campos que NO se pueden actualizar
            unset($socioData['cedula']);
            unset($socioData['fecha_afiliacion']);
            unset($socioData['cupo']);

            $user->socio->update($socioData);
        }

        Notification::make()
            ->success()
            ->title('Perfil actualizado')
            ->body('Tus datos han sido actualizados correctamente.')
            ->send();
    }

    public static function canAccess(): bool
    {
        return Auth::check();
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        if (!$user) {
            return false;
        }

        $allowedRoles = ['socio', 'presidente', 'secretaria', 'tesorero', 'administrador'];
        return in_array($user->rol, $allowedRoles);
    }
}
