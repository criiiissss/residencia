<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gerencia extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'num'
    ];

    public function gerencia(){
        return $this->hasMany(Zona::class, 'idGerencia');
    }
}
