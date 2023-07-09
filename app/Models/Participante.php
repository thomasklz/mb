<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Crypt;
use Laravel\Sanctum\HasApiTokens;

class Participante extends Model
{
    use HasFactory,HasApiTokens;
    public $timestamps = false;
    protected $table = 'participantes';
    protected $fillable =['nombres','cedula','email','password','semestre','telefono','rol'];
    protected $hidden = [
        'password'
    ];

    public function Post(){
        return $this->hasMany(Post::class);
    }
    public function Cometario_Post(){
        return $this->hasMany(Cometario_Post::class);
    }
    public function Like(){
        return $this->hasMany(Like::class);
    }

}
