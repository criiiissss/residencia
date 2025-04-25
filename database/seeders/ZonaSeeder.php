<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Zona;

class ZonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $i = 0;
        $zonas = ["Zona de Transmisión Villahermosa",
                "Zona de Transmisión Tuxtla",
                "Zona de Transmisión Tapachula",
                "Zona de Transmisión Istmo",
                "Zona de Transmisión Malpaso",
                "Sede GRTSE"];
        $enum = ["T141","T142","T143","T144","T145","T140"];

        foreach ($zonas as $zona) {
            $zonaNueva = New Zona();
            $zonaNueva->name = $zona;
            $zonaNueva->enum = $enum[$i];
            $i = $i+1;
            $zonaNueva->idGerencia  = 8;
            $zonaNueva->save();
        }
    }
}
