<?php

namespace App\Models\Maps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'idMedicions',
        'noFibra',
        'estado',
        'medicion',
        'comentario',
        'xor',
    ];
    //RELACIONES

    public function medicions(){
        return $this->belongsTo(Medicion::class, 'idMedicions');
    }

    public function detalles(){
        return $this->hasMany(Evento::class, 'idDetalle');
    }
}
