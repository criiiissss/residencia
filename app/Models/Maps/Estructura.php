<?php

namespace App\Models\Maps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estructura extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',             //NOMBRE DE LA ESTRUCTURA 
        'lat',              //LATITUD DE LA ESTRUCTURA
        'lng',              //LONGITUD DE LA ESTRUCTURA
        'cajaEmpalme',             //TIPO DE LA ESTRUCTURA ESTA PUEDE SER (CAJA DE EMPALME O TORRE)
        'distancia',        //DISTANCIA REGISTRADA PARA ESTE ENLACE
        'idEnlace',         //RELACION CON EL MODELO DE ENLACE
    ];
    //RELACIONES
        //VINCULACION CON EL MODELO
        public function enlaces()
        {
            return $this->belongsTo(Enlace::class,'idEnlace');
        }
}
