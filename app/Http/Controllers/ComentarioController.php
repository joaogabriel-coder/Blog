<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Models\Comentario;
use App\Models\Publicacao;
use App\Models\Usuario;

class ComentarioController extends Controller
{
    public function index()
    {
        $comentarios = Comentario::all();
        return response()->json($comentarios);
    }

    public function store(Request $request)
    {
        $data = $request->only(['usuario_id', 'publicacao_id']);
        $comentariosID = $data['publicacao_id'];

        if(!Publicacao::find($comentariosID)) {
            return response()->json([
                'message' => 'Publicação não encontrada.',
                'detalhe' => "Não exiuste publicação com o ID {$comentariosID}."
            ], 404);
        }

        $comentarios = Comentario::create($request->all());
        return response()->json($comentarios, 201);
    }

    
    public function update(Request $request, string $id)
    {
        $data = $request->only(['usuario_id', 'publicacao_id']);
        $comentariosID = $data['publicacao_id'];
        if(!Publicacao::find($comentariosID)) {
            return response()->json([
                'message' => 'Publicação não encontrada.',
                'detalhe' => "Não exiuste publicação com o ID {$comentariosID}."
            ], 404);
        }
        $comentarios = Comentario::findOrFail($id);
        $comentarios->update($request->all());
        $comentarios->save();
        return response()->json([
            'message' => 'Comentário atualizado com sucesso',
            'comentarios' => $comentarios
        ]);
    }

    public function destroy(string $id)
    {   
        Comentario::destroy($id);
        return response()->json([
            'message' => 'Comentário deletado com sucesso'
        ]);
    }
}
