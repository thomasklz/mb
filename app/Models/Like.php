<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'likes';
    protected $fillable =['participante_id','post_id'];
    public function Post():BelongsTo{
        return $this->belongsTo(Post::class);
    }
    public function Participante():BelongsTo{
        return $this->belongsTo(Participante::class);
    }
}
