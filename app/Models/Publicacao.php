<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Publicacao extends Model
{
    use HasFactory;

    protected $table = 'publicacoes';
    protected $fillable = [
        'titulo',
        'conteudo',
        'usuario_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'publicacao_id');
    }  
}
