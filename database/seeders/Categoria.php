<?php

namespace Database\Seeders;

use App\Models\Categoria as ModelsCategoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Categoria extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $categorias=array("Personas y naturaleza","Paisaje","Agua","Vida silvestre","Plantas y hongos","Clima");

        foreach ($categorias as $c) {
            ModelsCategoria::create([
                "nombre"=>$c
            ]);
        }


    }
}
