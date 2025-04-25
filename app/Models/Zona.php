<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Maps\Ubicacion;
use App\Models\Maps\Enlace;

class Zona extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'num',
        'idGerencia',
    ];

    public function zona(){
        return $this->belongsToMany(Enlace::class, 'zona_enlace');
    }

    public function gerencia(){
        return $this->belongsTo(Gerencia::class, 'idGerencia');
    }

    public function ubicacionesZonas(){
        return $this->belongsToMany(Ubicacion::class, 'zona_ubicacions');  //DE ESTE MODELO A UBICACION Y DE UBICACION A ESTE MODELO
    }

}
