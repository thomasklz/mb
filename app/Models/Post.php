<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'posts';
    protected $fillable =['titulo','descripcion','lugar','ciudad','fecha','imagen_id','categoria_id','participante_id','calificacionFinal'];

    public function Imagen():BelongsTo{
        return $this->belongsTo(Imagen::class);
    }
    public function Categoria():BelongsTo{
        return $this->belongsTo(Categoria::class);
    }
    public function Participante():BelongsTo{
        return $this->belongsTo(Participante::class);
    }
    public function Calificacion(): HasMany{
        return $this->hasMany(Calificacion::class);
    }
    public function Comentario_Post(): HasMany
    {
        return $this->HasMany(Comentario_Post::class);
    }
    public function Like(): HasMany
    {
        return $this->HasMany(Like::class);
    }

}


