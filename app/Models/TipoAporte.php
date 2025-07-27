<?php

namespace App\Models;

use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

use Illuminate\Database\Eloquent\Model;

class TipoAporte extends Model implements AuditableContract
{
    use Auditable;

    protected $table ="tipos_aporte";
    public $timestamps = false;

    protected $fillable = [
        'clave',
        'nombre',
        'descripcion'
    ];

    public function aportes()
    {
        return $this->hasMany(Aporte::class);
    }
}
