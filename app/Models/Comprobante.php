<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Comprobante extends Model implements AuditableContract
{
    use Auditable;

    protected $fillable = [
        'codigo',
        'socio_id',
        'total',
        'metodo_pago',
        'referencia_pago',
        'observaciones',
    ];

    // Generar UUID si no viene
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->codigo)) {
                $model->codigo = (string) Str::uuid();
            }
        });
    }

    public function socio()
    {
        return $this->belongsTo(Socio::class);
    }

    public function detalles()
    {
        return $this->hasMany(ComprobanteDetalle::class, 'comprobante_id');
    }
}
