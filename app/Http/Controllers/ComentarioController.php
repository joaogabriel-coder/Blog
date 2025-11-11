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
        $data = $request->only(['publicacao_id']);
        $comentariosID = $data['publicacao_id'];

        $usuario = auth()->user();
        $comentarios = new Comentario();
        $comentarios->texto = $request->texto;
        $comentarios->publicacao_id =$request->publicacao_id;
        $comentarios->usuario_id = auth()->id();

        if(!Publicacao::find($comentariosID)) {
            return response()->json([
                'message' => 'Publicação não encontrada.',
                'detalhe' => "Não exiuste publicação com o ID {$comentariosID}."
            ], 404);
        }

       $comentarios->save();
        return response()->json($comentarios, 201);
    }


    public function update(Request $request, string $id)
    {
        $comentarios = Comentario::findOrFail($id);
        $usuario = auth()->user();

        if($comentarios->usuario_id !== $usuario->id){
            return response()->json([
                'messege'=> 'Você não tem permissão para editar esse comentário'
            ], 403);
        }

        if(!Publicacao::find($comentarios->publicacao_id)) {
            return response()->json([
                'message' => 'Publicação não encontrada.',
                'detalhe' => "Não exiuste publicação com o ID {$comentariosID}."
            ], 404);
        }

        $comentarios->save();
        return response()->json([
            'message' => 'Comentário atualizado com sucesso',
            'comentarios' => $comentarios
        ]);
    }

    public function destroy(string $id)
    {
        $comentarios = Comentario::findOrFail($id);
        $usuario = auth()->user();
        if($comentarios->usuario_id !== $usuario->id){
            return response()->json([
                'messege'=> 'Você não tem permissão para excluir essa publicação'
            ], 403);
        }
        Comentario::destroy($id);
        return response()->json([
            'message' => 'Comentário deletado com sucesso'
        ]);
    }
}
