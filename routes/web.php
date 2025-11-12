<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\Usuario;
use App\Http\Controllers\PasswordResetController;


Route::get('/', function () {
    return view('welcome');
});

//rota para mostrar a view para o usuário digitar seu email para fazer a verificação
Route::get('/esqueci-a-senha', function(){
    return view('auth.forgot-password');
})->name('password.forgot');

//rota para mostrar a view para o usuário digitar o codigo OTP
Route::get('/verificacao-otp', function(){
    return view('auth.confirmation-otp');
})->name('otp-verificacao');

//rota para mostrar a view para o usuario digitar sua nova senha
Route::get('/resetar-senha', function(){
    return view('auth.reset-password');
})->name('senha-resetar');

//rotas que os formulários POST envia
Route::post('/password/solicitar-reset', [PasswordResetController::class, 'solicitarReset'])->name('password.solicitar-reset');
Route::post('/verificacao/verificar-otp', [PasswordResetController::class, 'verificarOtp'])->name('verificacao.verificar-otp');
Route::post('/password/redefinir', [PasswordResetController::class, 'redefinirSenha'])->name('password.redefinir');
