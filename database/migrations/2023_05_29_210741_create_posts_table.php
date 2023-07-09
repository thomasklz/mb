<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('descripcion');
            $table->string('lugar');
            $table->string('ciudad');
            $table->dateTime('fecha');
            $table->double('calificacionFinal')->nullable();

        //Relaciones
        //imagen
            $table->foreignId('imagen_id')
            ->constrained('imagenes')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
        //categoria
         $table->foreignId('categoria_id')
         ->constrained('categorias')
         ->cascadeOnDelete()
         ->cascadeOnUpdate();
        //Participantes
        $table->foreignId('participante_id')
        ->constrained('participantes')
        ->cascadeOnDelete()
        ->cascadeOnUpdate();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
