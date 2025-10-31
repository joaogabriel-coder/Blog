<?php

namespace Database\Factories;

use App\Models\Comentario;
use App\Models\Usuario;
use App\Models\Publicacao;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComentarioFactory extends Factory
{
    protected $model = Comentario::class;

    public function definition(): array
    {
        $usuario = Usuario::inRandomOrder()->first();
        $publicacao = Publicacao::inRandomOrder()->first();

        return [
            'usuario_id'    => $usuario ? $usuario->id : Usuario::factory()->create()->id,
            'publicacao_id' => $publicacao ? $publicacao->id : Publicacao::factory()->create()->id,
            'texto'      => $this->faker->sentence(),
        ];
    }
}
