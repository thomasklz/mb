<?php

namespace Database\Seeders;

use App\Models\Comentario_Post;
use Illuminate\Database\Seeder;

class ComentarioPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comentario_Post::factory(60)->create();
    }
}
