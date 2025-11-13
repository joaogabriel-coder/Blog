<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Models\Usuario;
use App\Models\PasswordResetToken;
use Illuminate\Http\Response;

class PasswordResetController extends Controller
{
    public function solicitarReset(Request $request)
    {
        $request->validate([
            'email'=> 'required|email|exists:usuarios,email'
        ]);
        $usuario = Usuario::where('email', $request->email)->first();
        $otp_code = random_int(100000, 999999);
        $token = Str::random(64);

        PasswordResetToken::updateOrCreate(
            ['email'=> $request->email],
            [
                'otp_code' =>$otp_code,
                'token'=>$token,
                'expires_at'=>Carbon::now()->addMinutes(15),
            ]
        );
         Mail::raw("Seu código de verificação é: $otp_code", function ($message) use ($usuario) {
            $message->to($usuario->email)
                    ->subject('Código de verificação - Redefinição de senha');
        });

        //return redirect()
           // ->route('otp-verificacao')
            //->with('email', $usuario->email)
            //->with('success', 'Um código de verificação foi enviado para seu e-mail.');
            return response()->json([
                'massege'=>'Código enviado com sucesso'
            ], 200);
    }

    public function verificarOtp(Request $request)
    {
        $request->validate([
            'email'=>'required|email|exists:usuarios,email',
            'otp_code'=>'required|string|size:6',
        ]);
        
    }

    public function redefinirSenha(Request $request)
    {

    }
}
