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
        $Estoques = Estoque::estoquesPropriedade($propriedade->id);

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
