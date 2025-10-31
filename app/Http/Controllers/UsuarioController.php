<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;


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
        $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:usuarios,email,'.$id,
            'password' => 'sometimes|required|string|min:6',
        ]);
        $usuario = Usuario::findOrFail($id);
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
        Usuario::destroy($id);
        return response()->json([
            'message' => 'Usuário deletado com sucesso'
        ], 200);
    }
}
