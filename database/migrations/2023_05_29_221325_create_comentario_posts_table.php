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
        Schema::create('comentario_posts', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');

            //Relaciones

            //Comentario
            $table->foreignId('comentario_id')
            ->constrained('comentarios')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
            //Participante
            $table->foreignId('participante_id')
            ->constrained('participantes')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
            //Post
            $table->foreignId('post_id')
            ->constrained('posts')
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
        Schema::dropIfExists('comentario-_posts');
    }
};
