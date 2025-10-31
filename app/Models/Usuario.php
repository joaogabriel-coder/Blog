<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Publicacao;
use App\Models\Favorito;
use App\Models\Comentario;

class Usuario extends Model
{
    use HasFactory;
    protected $table = 'usuarios';
    protected $fillable = [
        'nome',
        'email',
        'password',
    ];
    public function publicacoes()
    {
        return $this->hasMany(Publicacao::class, 'usuario_id');
    }
    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'usuario_id');
    }   
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'usuario_id');
    }
}
