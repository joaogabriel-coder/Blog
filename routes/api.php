<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PubliController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FavoritoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::apiResource('/usuarios', UsuarioController::class);
Route::get('/usuarios/{id}/publicacoes', [UsuarioController::class, 'publicacoes']);
Route::get('/usuarios/{id}/favoritos', [UsuarioController::class, 'favoritos']);

Route::post('/login', function (Request $request){
    $credentials = $request->only('email', 'password');
    if(Auth::attempt($credentials) === false){
        return response()->json(['message' => 'Credenciais inválidas'], 401);
    }
    $user = Auth::user();
    $token = $user->createToken('auth_token');
    return response()->json([
        'access_token' => $token->plainTextToken,
        'token_type' => 'Bearer'
    ]);
});

Route::apiResource('/publicacoes', PubliController::class);

Route::apiResource('/comentarios', ComentarioController::class);

Route::apiResource('/favoritos', FavoritoController::class);
