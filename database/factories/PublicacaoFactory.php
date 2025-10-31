<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Publicacao;
use App\Models\Usuario;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publicacao>
 */
class PublicacaoFactory extends Factory
{
    protected $model = Publicacao::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $usuario = Usuario::inRandomOrder()->first();
        return [
            'usuario_id' => $usuario ? $usuario->id : Usuario::factory()->create()->id,
            'titulo' => $this->faker->sentence(),
            'descricao' => $this->faker->paragraph(),
            'foto' => $this->faker->imageUrl(640, 480, 'cats', true),
        ];
    }
}
