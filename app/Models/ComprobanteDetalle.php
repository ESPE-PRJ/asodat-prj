<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class ComprobanteDetalle extends Model implements AuditableContract
{
    use Auditable;

    protected $table = 'comprobante_detalle';

    public $timestamps = false;
    protected $fillable = [
        'comprobante_id',
        'aporte_id',
        'monto_aplicado',
    ];

    public function comprobante()
    {
        return $this->belongsTo(Comprobante::class, 'comprobante_id');
    }

    public function aporte()
    {
        return $this->belongsTo(Aporte::class, 'aporte_id');
    }
}
