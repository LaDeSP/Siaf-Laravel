<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estoque;
use App\Models\Produto;
use App\Models\Plantio;
use App\Models\Propriedade;
use Illuminate\Support\Facades\DB;

class EstoqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $propiedade=$this->getPropriedade($request);
        $allEstoque = DB::table('estoque')
          ->join('produto', 'estoque.produto_id', '=', 'produto.id')
          ->join('propriedade','estoque.propriedade_id','=','propriedade.id')
          ->join('plantio','plantio.id','=','estoque.plantio_id')
          ->join('talhao','plantio.talhao_id','=','talhao.id')
          ->join('manejo','plantio.id')
          ->where('estoque.propriedade_id','=',$propiedade->id)
          ->get(['estoque.id','estoque.quantidade','estoque.produto_id','produto.nome as nomep','data','estoque.propriedade_id','propriedade.nome','plantio_id','plantio.data_semeadura','plantio.data_plantio','talhao.nome as nomet']);

        return $allEstoque;

    }




}
