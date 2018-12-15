<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estoque;
use App\Models\Produto;
use App\Models\Perda;
use App\Models\Talhao;
use App\Models\Plantio;
use App\Models\Propriedade;
use App\Models\ManejoPlantio;
use Illuminate\Support\Facades\DB;



class PerdaController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }
    public function index(Request $request,$id)
    {
      $propriedade=$this->getPropriedade($request);
      $Estoques=Estoque::estoquesPropriedade($propriedade->id);
      foreach ($Estoques as $key => $Estoque) {
        $Estoque->disponivel=Estoque::produtosDisponiveis($Estoque->id);
      }
      $destinos=$destinos = DB::table('destino')
              ->select('destino.id', 'nome AS destino')
              ->where('destino.deleted_at','=',null)
              ->where('destino.tipo','=',0)
  			      ->get();


      return view('perdaForm', ["User"=>$this->getFirstName($this->usuario['name']) , "Tela"=>"Perda", 'Url'=>'url','Method'=>'post','estoques'=>$Estoques,'destinos'=>$destinos ]);
    }
}
