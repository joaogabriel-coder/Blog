<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Models\Publicacao;
use App\Models\Usuario;


class PubliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publicacoes = Publicacao::all();
        return response()->json($publicacoes);
    }

    
    public function store(Request $request)
    {
        $publicacao = Publicacao::create($request->all());
        return response()->json($publicacao, 201);
    }

    public function update(Request $request, string $id)
    {
        $publicacao = Publicacao::findOrFail($id);
        $publicacao->update($request->all());

        $publicacao->save();

        return response()->json([
            'message' => 'Publicação atualizada com sucesso',
            'publicacao' => $publicacao
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Publicacao::destroy($id);
        return response()->json([
            'message' => 'Publicação deletada com sucesso'
        ]);
    }
}
