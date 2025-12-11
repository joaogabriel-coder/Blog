<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PubliController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\PasswordResetController;
use Illuminate\Http\Request;

// --- ROTAS PROTEGIDAS (PRECISAM DE TOKEN) ---
Route::middleware('auth:sanctum')->group(function (){
    Route::apiResource('/usuarios', UsuarioController::class)->except(['store']); // Store geralmente é público (registro)
    Route::get('/usuarios/{id}/publicacoes', [UsuarioController::class, 'publicacoes']);
    Route::get('/usuarios/{id}/favoritos', [UsuarioController::class, 'favoritos']);
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);
    Route::post('/logout', [UsuarioController::class, 'logout']);

    Route::apiResource('/publicacoes', PubliController::class);
    Route::get('/publicacoes/{id}', [PubliController::class, 'show']);

    Route::apiResource('/comentarios', ComentarioController::class);

    Route::apiResource('/favoritos', FavoritoController::class);
});

// --- ROTAS PÚBLICAS ---
Route::post('/login', [UsuarioController::class, 'login']);
Route::post('/usuarios', [UsuarioController::class, 'store']); // Registro de usuário

// Rotas de recuperação de senha
Route::post('/password/solicitar-reset', [PasswordResetController::class, 'solicitarReset'])->name('password.solicitar-reset');
Route::post('/verificacao/verificar-otp', [PasswordResetController::class, 'verificarOtp'])->name('verificacao.verificar-otp');
Route::post('/password/redefinir', [PasswordResetController::class, 'redefinirSenha'])->name('password.redefinir');

// --- CORREÇÃO DE CORS FINAL (A "MÁGICA") ---
// Esta rota captura qualquer requisição do tipo OPTIONS (Preflight)
// que o navegador faz antes do POST, e força uma resposta positiva.
Route::options('/{any}', function (Request $request) {
    return response('', 200)
        ->header('Access-Control-Allow-Origin', '*') 
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, X-Token-Auth, Authorization');
})->where('any', '.*');