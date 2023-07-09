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
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id();
            $table->double('total');
            $table->double('contenido');
            $table->double('organizacion_estatica');
            $table->double('creatividad');
            $table->double('tecnica');

            //Relaciones
            //Post
            $table->foreignId('post_id')
            ->constrained('posts')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
            //Jurado
            $table->foreignId('user_id')
            ->constrained('users')
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
        Schema::dropIfExists('calificacions');
    }
};
