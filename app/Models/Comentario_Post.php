<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comentario_Post extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table ='comentario_posts';
    protected $fillable =['fecha','comentario_id','participante_id','post_id'];
    public function Comentario():BelongsTo{
        return $this->belongsTo(Comentario::class);
    }
    public function Post():BelongsTo{
        return $this->belongsTo(Post::class);
    }
    public function Participante():BelongsTo{
        return $this->belongsTo(Participante::class);
    }
}
