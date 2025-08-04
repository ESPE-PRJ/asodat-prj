<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Aporte extends Model implements AuditableContract
{
    use Auditable;

    protected $fillable = [
        'socio_id',
        'tipo_aporte_id',
        'periodo',
        'monto',
        'estado',
    ];

    protected $casts = [
        'periodo' => 'date',
        'monto' => 'decimal:2',
    ];

    // Estados disponibles
    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_PAGADO = 'pagado';
    const ESTADO_VENCIDO = 'vencido';

    public static function getEstados()
    {
        return [
            self::ESTADO_PENDIENTE => 'Pendiente',
            self::ESTADO_PAGADO => 'Pagado',
            self::ESTADO_VENCIDO => 'Vencido',
        ];
    }

    public function socio()
    {
        return $this->belongsTo(Socio::class);
    }

    public function tipoAporte()
    {
        return $this->belongsTo(TipoAporte::class, 'tipo_aporte_id');
    }

    public function detalles()
    {
        return $this->hasMany(ComprobanteDetalle::class, 'aporte_id');
    }

    // Métodos de acceso para Filament
    public function getSocioNombreAttribute()
    {
        return $this->socio ? $this->socio->apellidos_nombres : 'N/A';
    }

    public function getTipoAporteNombreAttribute()
    {
        return $this->tipoAporte ? $this->tipoAporte->nombre : 'N/A';
    }

    public function getEstadoFormateadoAttribute()
    {
        return self::getEstados()[$this->estado] ?? $this->estado;
    }

    // Scopes para filtros
    public function scopePendientes($query)
    {
        return $query->where('estado', self::ESTADO_PENDIENTE);
    }

    public function scopePagados($query)
    {
        return $query->where('estado', self::ESTADO_PAGADO);
    }

    public function scopeVencidos($query)
    {
        return $query->where('estado', self::ESTADO_VENCIDO);
    }

    public function scopePorPeriodo($query, $desde, $hasta)
    {
        return $query->whereBetween('periodo', [$desde, $hasta]);
    }
}
