<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Noticia extends Model implements AuditableContract
{
    use Auditable;

    protected $fillable = [
        'titulo',
        'contenido',
        'categoria',
        'imagen_path',
        'publicar_desde',
        'publicar_hasta',
    ];

    protected $dates = [
        'publicar_desde',
        'publicar_hasta',
    ];
}
