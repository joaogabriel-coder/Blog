<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Favorito;
use App\Models\Publicacao;
use App\Models\Usuario;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Favorito>
 */
class FavoritoFactory extends Factory
{
    protected $model = Favorito::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $usuario = Usuario::inRandomOrder()->first();
        $publicacao = Publicacao::inRandomOrder()->first();
        return [
            'usuario_id'    => $usuario ? $usuario->id : Usuario::factory()->create()->id,
            'publicacao_id' => $publicacao ? $publicacao->id : Publicacao::factory()->create()->id,
        ];
    }
}
