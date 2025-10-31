<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Usuario;
use App\Models\Favorito;

class Publicacao extends Model
{
    use HasFactory;

    protected $table = 'publicacoes';
    protected $fillable = [
        'titulo',
        'descricao',
        'usuario_id',
        'foto',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'publicacao_id');
    }  
}
