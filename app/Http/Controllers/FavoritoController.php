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
}
