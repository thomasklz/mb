<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Calificacion;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

         $this->call(CsvSeeder::class);
        $this->call(Jurado::class);
        $this->call(Comentario::class);
        $this->call(Categoria::class);
   /*       $this->call(ImageSeeder::class);
         $this->call(PostSeeder::class); */
    /*      $this->call(ComentarioPostSeeder::class);
        $this->call(LikeSeeder::class);  */
        /* $this->call(CalificacionSeeder::class); */
    }
}
