<?php

namespace App\Models\Maps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;
    protected $fillable = [
        'idDetalle',
        'distancia',
        'atenuacion',
    ];

    //RELACIONES
        //RELACIONE CON LA TABLA DETALLE
        public function detalles(){
            return $this->belongsTo(Detalle::class, 'idDetalle');
        }
}
