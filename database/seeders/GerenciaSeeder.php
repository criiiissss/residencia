<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gerencia;

class GerenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $NombreGerencias = ['Gerencia Regional de Transmisión Baja California',
                            'Gerencia Regional de Transmisión Noroeste',
                            'Gerencia Regional de Transmisión Norte',
                            'Gerencia Regional de Transmisión Noreste',
                            'Gerencia Regional de Transmisión Occidente',
                            'Gerencia Regional de Transmisión Central',
                            'Gerencia Regional de Transmisión Oriente',
                            'Gerencia Regional de Transmisión Sureste',
                            'Gerencia Regional de Transmisión Peninsular',
                            'Gerencia Regional de Transmisión Valle México'];

        $enumGerencias = ['T70','T80','T90','T100','T110','T120','T130','T140','T150','T160'];
        $i =0;
        foreach ($NombreGerencias as $name) {
            $gerencia01 = new Gerencia();
            $gerencia01->name = $name;
            $gerencia01->enum = $enumGerencias[$i];
            $i=$i+1;
            $gerencia01->save();
            }
        

        
    }
}
