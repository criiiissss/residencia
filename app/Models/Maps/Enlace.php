<?php

namespace App\Models\Maps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Zona;
use App\Models\Ubicacion;

class Enlace extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',                     //NOMBRE DEL ENLACE
        'tipo',                     //TIPO DEL ENLACE PUEDEN SER LOS SIGUIENTES(400KV,230KV,115KV,13.8KV,SUBTERRANEO)
        'km',                       //DISTANCIA EN KILOMETROS QUE TIENE DICHO ENLACE
        'atenuacionKm',
        'conectores',               //CANTIDAD DE CONECTORES CON LOS QUE SE CUENTA
        'atenuacionConectores',
        'atenuacionIdeal',          //ATENUACION IDEAL CALCULADA
        'cajasEmpalme',             //CANTIDAD DE CAJAS DE EMPALME
        'atenuacioncajas',
        'idMedicionUltima',
        'noFibras',
        
        
    ];

    //RELACIONES
        //RELACION DE UBICACION A ENLACE
            // Relación Muchos a Muchos con Ubicacion

            public function medic(){
                return $this->belongsTo(Medicion::class, 'idMedicionUltima');
            }

            public function zona(){
                return $this->belongsToMany(Zona::class, 'enlace_zonas');
            }

            public function ubicaciones()
            {
                return $this->belongsToMany(Ubicacion::class, 'enlace_ubicacions');  //DE ESTE MODELO A UBICACION Y DE UBICACION A ESTE MODELO
            }

            //Relacion de ENLACE A ESTRUCTURAS
            public function enlaces()
            {
                return $this->hasMany(Estructura::class,'idEnlace');
            }

            //Relacion de Enlace a Medicion
            public function lineas(){
                return $this->hasMany(Medicion::class, 'idLinea');
            }

    
}
