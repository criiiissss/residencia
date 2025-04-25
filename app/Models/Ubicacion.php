<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Maps\Enlace;

class Ubicacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',         //NOMBRE DE LA UBICACION DADA
        'abreviacion',  //ABREVIACION DE LA UBICACION
        'lat',          //LATITUD DE LA UBICACION
        'lng',          //LONGITUD DE LA UBICACION
        'idZona',       //REGISTRO DE ZONA
        'direccion',
    ];

    //RELACIONES
        //RELACION CON EL MODELO ENLACE
            public function enlaces()
            {
                return $this->belongsToMany(Enlace::class, 'enlace_ubicacions');
            }
        //RELACION CON EL MODELO MEDICIONES
            public function obtenerPuntaA()
            {
                return $this->hasMany(Medicion::class, 'idPuntaA');
            }

            public function obtenerPuntaB()
            {
                return $this->hasMany(Medicion::class, 'idPuntaB');
            }

            public function zona(){
                return $this->belongsTo(Zona::class, 'idZona');
            }
}
