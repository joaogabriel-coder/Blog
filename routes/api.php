<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PubliController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FavoritoController;

Route::apiResource('/usuarios', UsuarioController::class);
Route::get('/usuarios/{id}/publicacoes', [UsuarioController::class, 'publicacoes']);
Route::get('/usuarios/{id}/favoritos', [UsuarioController::class, 'favoritos']);

Route::apiResource('/publicacoes', PubliController::class);

Route::apiResource('/comentarios', ComentarioController::class);

Route::apiResource('/favoritos', FavoritoController::class);

