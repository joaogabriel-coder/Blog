<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UsuarioSeeder;
use Database\Seeders\PublicacaoSeeder;
use Database\Seeders\ComentarioSeeder;
use Database\Seeders\FavoritoSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            UsuarioSeeder::class,
            PublicacaoSeeder::class,
            ComentarioSeeder::class,
            FavoritoSeeder::class,
        ]);
    }
}
