<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Socio extends Model implements AuditableContract
{
    // Usar el trait Auditable para la auditoría
    use Auditable;

    protected $fillable = [
        'cedula',
        'apellidos_nombres',
        'campus',
        'genero',
        'regimen',
        'celular',
        'cargo',
        'direccion',
        'fecha_afiliacion',
        'correo',
        'tipo_usuario',
        'cupo',
        'documento_pdf_path',
        'observaciones',
    ];

    // Configuración de auditoría
    protected $auditInclude = [
        'cedula',
        'apellidos_nombres',
        'campus',
        'genero',
        'regimen',
        'celular',
        'cargo',
        'direccion',
        'fecha_afiliacion',
        'correo',
        'tipo_usuario',
        'cupo',
        'observaciones',
    ];

    protected $auditEvents = [
        'created',
        'updated',
        'deleted',
    ];

    // Etiquetas personalizadas para auditoría
    protected $auditFields = [
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
    ];

    // Relaciones
    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function aportes()
    {
        return $this->hasMany(Aporte::class);
    }

    public function comprobantes()
    {
        return $this->hasMany(Comprobante::class);
    }

    public function audits(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(\OwenIt\Auditing\Models\Audit::class, 'auditable')->orderBy('created_at', 'desc');
    }
}
