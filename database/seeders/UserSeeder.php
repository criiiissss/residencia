<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $usuarioEjemplo = new User();
        $usuarioEjemplo->name = 'Ivan Alberto';
        $usuarioEjemplo->apellido = 'Adriano Ordaz';
        $usuarioEjemplo->rpe = '123a123';
        $usuarioEjemplo->email = 'adrianoordaz150@gmail.com';
        $usuarioEjemplo->password = '123';
        $usuarioEjemplo->rol = 'level3';
        $usuarioEjemplo->save();
    }
}
