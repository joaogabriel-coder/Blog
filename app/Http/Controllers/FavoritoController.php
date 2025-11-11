<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Models\Favorito;
use App\Models\Publicacao;
use App\Models\Usuario;


class FavoritoController extends Controller
{
    public function index()
    {
        $favorito = Favorito::all();
        return response()->json($favorito);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'publicacao_id'=> 'required|integer|exists:publicacoes,id',
        ]);

        $usuarioID = auth()->id();
        $publicacaoID =Publicacao::find($data['publicacao_id']);

        if(!Publicacao::find($publicacaoID)) {
            return response()->json([
                'message' => 'Publicação não encontrada.',
                'detalhe' => "Não existe publicação com o ID {$publicacaoID}."
            ], 404);
        }
        $data['usuario_id'] = $usuarioID;

        $favorito = Favorito::firstOrCreate($data);
        if($favorito->wasRecentlyCreated) {
            return response()->json($favorito, 201);
        }
        return response()->json([
        'message' => 'Publicação já favoritada.',
        'favorito' => $favorito
    ], 200);
    }
    public function destroy(string $id)
    {
        $favorito = Favorito::findOrFail($id);
        $usuario = auth()->user();
        if($favorito->usuario_id !== $usuario->id){
            return response()->json([
                'messege'=> 'Você não tem permissão para excluir esse favorito'
            ], 403);
        }
        Favorito::destroy($id);
        return response()->json([
            'message' => 'Favorito deletado com sucesso'
        ]);
    }
}
