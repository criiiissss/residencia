<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnlaceZona extends Model
{
    use HasFactory;
    public function enlace(){
        return $this->belongsTo(Enlace::class, 'enlace_id');
    }

    public function zona(){
        return $this->belongsTo(Zona::class, 'zona_id');
    }
}
