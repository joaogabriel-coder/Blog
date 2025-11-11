<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\Publicacao;
use App\Models\Favorito;
use App\Models\Comentario;

class UsuarioController extends Controller
{

    public function index()
    {
        $usuarios = Usuario::all();
        return response()->json($usuarios);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios',
            'password' => 'required|string|min:6',
        ]);

        $usuario = Usuario::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'message' => 'Usuário criado com sucesso',
            'usuario' => $usuario
        ], 201);
    }

    public function publicacoes($id)
    {
        $usuario = Usuario::findOrFail($id);
        $publicacoes = $usuario->publicacoes;
        return response()->json([
            'usuario' => $usuario->nome,
            'publicacoes' => $publicacoes
        ]);
    }

    public function favoritos($id)
    {
        $usuario = Usuario::findOrFail($id);
        $favoritos = $usuario->favoritos()->with('publicacao.usuario')->get();

        return response()->json([
            'usuario' => $usuario->nome,
            'favoritos' => $favoritos
        ]);
    }

    public function update(Request $request, string $id)
    {
        $usuarios = auth()->user();
        $usuario = Usuario::findOrFail($id);

        if($usuarios->id !== $usuario->id){
        return response()->json([
                'message'=> 'Você não tem permissão de editar esse usuário'
            ], 403);
        }

         $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:usuarios,email,'.$id,
        ]);

        if ($request->has('nome')) {
            $usuario->nome = $request->nome;
        }
        if ($request->has('email')) {
            $usuario->email = $request->email;

        }

        $usuario->save();

        return response()->json([
            'message' => 'Usuário atualizado com sucesso',
            'usuario' => $usuario
        ], 200);
    }

    public function destroy(string $id)
    {
        $usuarios = auth()->user();
        $usuario = Usuario::findOrFail($id);

        if($usuarios->id !== $usuario->id){
        return response()->json([
                'message'=> 'Você não tem permissão de excluir esse usuário'
            ], 403);
        }

        if($usuario->foto) {
            Storage::disk('public')->delete($usuario->foto);
        }

        Publicacao::where('usuario_id', $id)->delete();
        Comentario::where('usuario_id', $id)->delete();
        Favorito::where('usuario_id', $id)->delete();

        $usuario->delete();

        return response()->json([
            'message' => 'Usuário deletado com sucesso'
        ], 200);
    }
    public function login(Request $request)
    {
        $usuario = Usuario::where('email', $request->email)->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        $usuario->tokens()->delete();

        $token = $usuario->createToken('api-token')->plainTextToken;

        return response()->json([
            'usuario' => $usuario,
            'token' => $token
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso']);
    }
}
