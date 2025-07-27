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
}
