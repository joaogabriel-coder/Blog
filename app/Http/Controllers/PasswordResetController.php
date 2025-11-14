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
                'expires_at'=>now()->addMinutes(15)->toDateTimeString(),
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
                'massege'=>'Código enviado com sucesso',
                'token'=> $token
            ], 200);
    }

    public function verificarOtp(Request $request)
    {
        $request->validate([
            'email'=>'required|email|exists:usuarios,email',
            'otp_code'=>'required|string|size:6',
            'token'=>'required'
        ]);
        $reset = PassWordResetToken::where('email', $request->email)
            ->where('otp_code', $request->otp_code)
            ->where('token', $request->token)
            ->first();
        if(!$reset){
            return response()->json([
                'message'=>'Código OTP ou token inválido'
            ], 400);
        }
        if (Carbon::parse($reset->expires_at)->isPast()) {
        return response()->json([
            'message' => 'Código expirado'
        ], 400);
        }

        //return redirect()
           // ->route('senha-resetar')
             //->with('token', $reset->token)
             //->with('email', $usuario->email)
             //->with('success', 'Código verificado com sucesso. Agora redefina sua senha');
        return response()->json([
            'message'=>'Código verificado com sucesso, redefina sua senha'
        ], 200);
    }

    public function redefinirSenha(Request $request)
    {
       $request->validate([
            'email'=>'required|email|exists:usuarios,email',
            'token'=>'required',
            'nova_senha'=>'required|min:6',
            'senha_confirmation'=>'required|same:nova_senha'
        ]);

        $reset = PassWordResetToken::where('email', $request->email)
            ->where('token', $request->token)
            ->first();
        if(!$reset){
            return response()->json([
                'message'=>'Token inválido'
            ], 400);
        }
        if (Carbon::parse($reset->expires_at)->isPast()) {
        return response()->json([
            'message' => 'Token expirado'
        ], 400);
        }
        $usuario = Usuario::where('email', $request->email)->first();
        $usuario->password = bcrypt($request->nova_senha);
        $usuario->save();

        $reset->delete();

        return response()->json([
            'message'=> 'Senha redefinida com sucesso'
        ]);
    }
}

