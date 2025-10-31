<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
