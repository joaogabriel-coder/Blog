<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favorito extends Model
{
    use HasFactory;
    protected $table = 'favoritos';
    protected $fillable = [
        'usuario_id',
        'publicacao_id',
    ];
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
    public function publicacao(){
        return $this->belongsTo(Publicacao::class);
    }
}
