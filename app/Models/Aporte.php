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
        'monto'   => 'decimal:2',
    ];

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
}
