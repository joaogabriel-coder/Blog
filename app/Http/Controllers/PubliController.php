<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Models\Publicacao;
use App\Models\Usuario;
use App\Models\Comentario;
use App\Models\Favorito;
use Illuminate\Support\Facades\Storage;


class PubliController extends Controller
{

    public function index()
    {
        $publicacoes = Publicacao::all();
        return response()->json($publicacoes);
    }
    public function show(string $id)
    {
        $publicacao = Publicacao::findOrFail($id);
        $comentarios = Comentario::where('publicacao_id', $id)->get();
        $favoritosCount = Favorito::where('publicacao_id', $id)->count();
        $favoritos = Favorito::where('publicacao_id', $id)->with('usuario')->get();

        $publicacao->comentarios = $comentarios;
        $publicacao->favoritos_count = $favoritosCount;
        $publicacao->favoritos = $favoritos;

        return response()->json($publicacao);
    }


    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao'=> 'required|string|max:255',
            'foto'=> 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $usuario = auth()->user();

        $publicacao = new Publicacao();
        $publicacao->titulo = $request->titulo;
        $publicacao->descricao = $request->descricao;
        $publicacao->usuario_id = auth()->id();

        $path = null;

        if($request->hasFile('foto')){
            $path = $request->file('foto')->store('images', 'public');
            $publicacao->foto = $path;
        }

        $publicacao->save();
        $urlCompleta = $path ? asset(Storage::url($path)) : null;

        return response()->json([
            'message' => 'Publicação criada com sucesso',
            'publicacao'=> [
                'id' => $publicacao->id,
                'titulo' => $publicacao->titulo,
                'descricao' => $publicacao->descricao,
                'usuario_id' => $publicacao->usuario_id,
                'foto_url' => $urlCompleta,
                'created_at' => $publicacao->created_at,
                'updated_at' => $publicacao->updated_at,
            ]
        ], 201);
    }

    public function update(Request $request, string $id)
    {
        $publicacao = Publicacao::findOrFail($id);
        $usuario = auth()->user();

        $publicacao->update($request->all());
        if($publicacao->usuario_id !== $usuario->id){
            return response()->json([
                'messege'=>'Você não tem permissão de excluir essa publicação'
            ], 403);
        }
        $publicacao->save();

        return response()->json([
            'message' => 'Publicação atualizada com sucesso',
            'publicacao' => $publicacao
        ]);
    }


    public function destroy(string $id)
    {
        $publicacao = Publicacao::findOrFail($id);
        $usuario = auth()->user();

        if($publicacao->usuario_id !== $usuario->id){
            return response()->json([
                'messege'=>'Você não tem permissão de excluir essa publicação'
            ], 403);
        }

        if($publicacao->foto) {
            Storage::disk('public')->delete($publicacao->foto);
        }

        Comentario::where('publicacao_id', $id)->delete();
        Favorito::where('publicacao_id', $id)->delete();

        $publicacao->delete();

        return response()->json([
            'message' => 'Publicação deletada com sucesso'
        ]);
    }
}
