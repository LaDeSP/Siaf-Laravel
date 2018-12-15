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
      $destinos=$destinos = DB::table('destino')
              ->select('destino.id', 'nome AS destino')
              ->where('destino.deleted_at','=',null)
              ->where('destino.tipo','=',0)
  			      ->get();
      $max=Estoque::produtosDisponiveis($id);
      return view('perdaForm', ["User"=>$this->getFirstName($this->usuario['name']) , "Tela"=>"Perda", 'Url'=>'/perda','Method'=>'post','Estoque'=>$id,'Destinos'=>$destinos,'Max'=>$max ]);
    }

    public function create(Request $request){
      $post = array_except($request,['_token'])->toArray();

      $plantio = new Perda($post);

      $salva=$plantio->save();
      if($salva==true){
        $status='success';
        $mensagem='Sucesso ao salvar o Perda!';
      }
      else{
        $status='danger';
        $mensagem='Erro ao salvar o Perda!';
      }

      return redirect()->action('EstoqueController@index', ['mensagem'=>$mensagem,'status'=>$status]);

    }

}
