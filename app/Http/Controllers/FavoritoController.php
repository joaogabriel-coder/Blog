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
        $favoritos = Favorito::all();
        return response()->json($favoritos);
    }
    public function store(Request $request)
    {
        $data = $request->only(['usuario_id', 'publicacao_id']);
        $publicacaoID = $data['publicacao_id'];

        if(!Publicacao::find($publicacaoID)) {
            return response()->json([
                'message' => 'Publicação não encontrada.',
                'detalhe' => "Não exiuste publicação com o ID {$publicacaoID}."
            ], 404);
        }

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
        Favorito::destroy($id);
        return response()->json([
            'message' => 'Favorito deletado com sucesso'
        ]);
    }
}
