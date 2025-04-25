<?php

namespace App\Models\Maps;
use App\Models\Ubicacion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicion extends Model
{
    use HasFactory;
    protected $fillable = [
        'idPuntaA',
        'idPuntaB',
        'idLinea',
        'atenuacionReal',
        'fecha',
        'ubicacionPDF',
        'ubicacionXLS',
    ];


    //RELACIONES

        public function obtenerPuntaA(){
            return $this->belongsTo(Ubicacion::class, 'idPuntaA');
        }

        public function obtenerPuntaB(){
            return $this->belongsTo(Ubicacion::class, 'idPuntaB');
        }

        public function lineas(){
            return $this->belongsTo(Enlace::class, 'idLinea');
        }

        public function medicions(){
            return $this->hasMany(Detalle::class, 'idMedicions');
        }
        
        public function medic(){
            return $this->hasMany(Enlace::class, 'idMedicionUltima');
        }
}
