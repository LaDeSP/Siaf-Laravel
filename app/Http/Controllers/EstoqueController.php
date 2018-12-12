<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estoque;
use App\Models\Produto;
use App\Models\Talhao;
use App\Models\Plantio;
use App\Models\Propriedade;
use App\Models\ManejoPlantio;
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
        $propriedade=$this->getPropriedade($request);
        $Estoques = DB::table('estoque')
          ->join('produto', 'estoque.produto_id', '=', 'produto.id')
          ->join('manejoplantio','estoque.manejoplantio_id','=','manejoplantio.plantio_id')
          ->join('plantio','plantio.id','=','manejoplantio.plantio_id')
          ->join('talhao','plantio.talhao_id','=','talhao.id')
          ->where('estoque.propriedade_id','=',$propriedade->id)
          ->where('manejoplantio.manejo_id','=',4)
          ->get(['estoque.id','estoque.quantidade','estoque.produto_id','produto.nome as nomep','data','estoque.propriedade_id','manejoplantio.plantio_id','plantio.data_semeadura','plantio.data_plantio','talhao.nome as nomet','manejoplantio.id as manejo_plantio_id','manejoplantio.descricao','manejoplantio.data_hora']);

          foreach ($Estoques as $key => $Estoque) {
            $Estoque->disponivel=Estoque::produtosDisponiveis($Estoque->id);
          }

          return view('estoque', ["User"=>$this->getFirstName($this->usuario['name']) ,'Estoques'=>$Estoques , "Tela"=>"Estoque"]);


    }

    public function create(Request $request){
            $propriedade=$this->getPropriedade($request);
            $colheitas= Estoque::coleheitaPropriedade($propriedade->id);
            $produtos=Produto::all()->where('propriedade_id','=',$propriedade['id']);
            $tmp = array("propriedade"=> $propriedade, "produto"=>$produtos ,'colehitas'=>$colheitas );
            return $tmp;
            return view('plantioForm', ["User"=>$this->getFirstName($this->usuario['name']) ,'Propriedade'=>$tmp , "Tela"=>"Adicionar Plantio" ,'Method'=>'post','Url'=>'/plantio']);
    }



}
