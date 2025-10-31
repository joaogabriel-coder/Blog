<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comentario extends Model
{
    use HasFactory;
    protected $table = 'comentarios';
    protected $fillable = [
        'texto',
        'publicacao_id',
        'usuario_id',
    ];
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
    public function publicacao(){
        return $this->belongsTo(Publicacao::class);
    }
}
