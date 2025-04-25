<?php

namespace App\Models\Maps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ubicacion;

class EnlaceUbicacion extends Model
{
    public function enlace(){
        return $this->belongsTo(Enlace::class, 'enlace_id');
    }

    public function ubicacion(){
        return $this->belongsTo(Ubicacion::class, 'ubicacion_id');
    }
}
