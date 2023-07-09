<?php

namespace Database\Seeders;

use App\Models\Comentario as ModelsComentario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Comentario extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comentarios=array("¡Hermoso foto! Me encanta la tranquilidad que transmite.","¡Impresionante escenario natural! Quiero visitarlo algún día.","Qué vista tan relajante, me hace sentir en paz instantáneamente.","La iluminación de la foto es un poco apagada, dificulta ver los detalles.","La composición de la imagen podría mejorarse para destacar mejor el paisaje.","La calidad de la imagen no es la mejor, se ve un poco borrosa.");

        foreach ($comentarios as $c) {
            ModelsComentario::create([
                "mensaje"=>$c
            ]);
        }


    }
}
