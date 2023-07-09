<?php

namespace Database\Seeders;

use App\Models\User as ModelsJurado;
use Illuminate\Database\Seeder;
use PhpParser\Node\Expr\Cast\Object_;

class Persona
{
    public $nombre;
    public $apellido;
    public $telefono;
    public $email;
    public $password;

    public function __construct($nombre, $apellido, $telefono, $email, $password)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->password = $password;
    }
}
class Jurado extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    $jurado1=new Persona('Lisa','W. Brunetti','0939675801','lisabrunetti_396758@hotmail.com','ft1@@00QqZd59l');
    $jurado2=new Persona('Luis Eladio','Alcívar Loor','0969341677','luiseladio_693416@hotmail.com','257kJM@V2!NdQ*');
    $jurado3=new Persona('Julia Angelita','Cordero Guillén','0999142496','juliaangelita991424@hotmail.com','0xIfnBdN^1GA15');
    $jurado4=new Persona('José Gabriel','Viteri Espinoza','0996398175','josegrabriel_963981@hotmail.com','Ac&9hF^2Zom^0q');
    $jurado5=new Persona('Ana Elizabeth','Ágreda De la Paz','0989560242','anaelizabeth_895602@hotmail.com','nIV1P0%p1h0L^T');
    $jurado6=new Persona('Juan Fernando','Pesántes Muñoz','0992365180','juanfernando_923651@hotmail.com','hi1SrMWR*M7ZQ2');
        $jurados = array($jurado1,$jurado2,$jurado3,$jurado4,$jurado5,$jurado6);
        ModelsJurado::create([
            "nombre" => "admin",
            "apellido" => "admin",
            "telefono" => "0963150796",
            "email" => "23sehPw93z040E%*#k3@hotmail.com",
            "password" => bcrypt('2P5qG7f#1HqJ#2'),
            "rol" => "admin"
        ]);
        foreach ($jurados as $jurado) {
            ModelsJurado::create([
                "nombre" => $jurado->nombre,
                "apellido" => $jurado->apellido,
                "telefono" => $jurado->telefono,
                "email" => $jurado->email,
                "password" => bcrypt($jurado->password),
                "rol" => "jurado"
            ]);
        }
    }
}
