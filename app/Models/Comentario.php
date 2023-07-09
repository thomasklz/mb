<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table ='comentarios';
    protected $fillable = ['mensaje'];
    public function Comentario_Post(){
        return $this->hasMany(Comentario_Post::class);
    }
}
