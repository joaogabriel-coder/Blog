<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PubliController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FavoritoController;

Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::get('/publicacoes', [PubliController::class, 'index']);
Route::get('/comentarios', [ComentarioController::class, 'index']);
Route::get('/favoritos', [FavoritoController::class, 'index']);
