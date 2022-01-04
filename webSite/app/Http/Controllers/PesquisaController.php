<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Models\Noticia;
use App\Models\Utilizador;

class PesquisaController extends Controller {
    
    public function show(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'paginacao' => 'integer | min:0',
            'sortBy' => 'integer | min:1 | max:4',
            'pesquisa' => 'required | string'
        ]);

        $pesquisa = $request->query('pesquisa');

        $reservedSymbols = ['\''];
        $pesquisa = $request -> query('paginacao') ?? 15;

        $sortby = $request->query('sortBy') ?? 3;

        $utilizadores = Utilizador::pesquisa($pesquisa, $sortby);

        $noticias = Noticia::pesquisa($pesquisa, $sortby);

        return view('pages.search', ['noticia' => $noticias, 'utilizador' => $utilizadores, 'query' => $pesquisa]);
    }
}