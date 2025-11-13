<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PubliController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\PasswordResetController;

Route::middleware('auth:sanctum')->group(function (){
    Route::apiResource('/usuarios', UsuarioController::class);
    Route::get('/usuarios/{id}/publicacoes', [UsuarioController::class, 'publicacoes']);
    Route::get('/usuarios/{id}/favoritos', [UsuarioController::class, 'favoritos']);
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);
    Route::post('/logout', [UsuarioController::class, 'logout']);

    Route::apiResource('/publicacoes', PubliController::class);
    Route::get('/publicacoes/{id}', [PubliController::class, 'show']);

    Route::apiResource('/comentarios', ComentarioController::class);

    Route::apiResource('/favoritos', FavoritoController::class);
});

Route::post('/login', [UsuarioController::class, 'login']);
Route::post('/usuarios', [UsuarioController::class, 'store']);

//rotas que os formulários POST envia
Route::post('/password/solicitar-reset', [PasswordResetController::class, 'solicitarReset'])->name('password.solicitar-reset');
Route::post('/verificacao/verificar-otp', [PasswordResetController::class, 'verificarOtp'])->name('verificacao.verificar-otp');
Route::post('/password/redefinir', [PasswordResetController::class, 'redefinirSenha'])->name('password.redefinir');
