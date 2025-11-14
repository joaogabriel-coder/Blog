<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Favorito;
use Illuminate\Database\UniqueConstraintViolationException;

class FavoritoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $totalDeTentativas = 50;
        $criadosComSucesso = 0;

        for($i = 0; $i < $totalDeTentativas; $i++){
            try{Favorito::factory()->create();
            $criadosComSucesso++;
        }catch(UniqueConstraintViolationException $e){
            continue;
            }
        }
    }
}
