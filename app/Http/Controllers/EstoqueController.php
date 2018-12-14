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
            $produtos=Produto::all()->where('propriedade_id','=',$propriedade['id'])->where('plantavel','=',0);
            $tmp = array("propriedade"=> $propriedade, "produto"=>$produtos  );

            return view('estoqueForm', ["User"=>$this->getFirstName($this->usuario['name']) ,'Propriedade'=>$tmp , "Tela"=>"Adicionar Estoque" ,'Method'=>'post','Url'=>'/estoque']);
    }

    public function store(Request $request){
      $post = array_except($request,['_token'])->toArray();
      $plantio = new Estoque($post);
      $salva=$plantio->save();
      if($salva==true){
        $status='success';
        $mensagem='Sucesso ao salvar o Estoque!';
      }
      else{
        $status='danger';
        $mensagem='Erro ao salvar o Estoque!';
      }
      $propriedade=$this->getPropriedade($request);
      $Estoques = Estoque::estoquesPropriedade($propriedade->id);

        foreach ($Estoques as $key => $Estoque) {
          $Estoque->disponivel=Estoque::produtosDisponiveis($Estoque->id);
        }

      return view('estoque', ["User"=>$this->getFirstName($this->usuario['name']) ,'Estoques'=>$Estoques , "Tela"=>"Estoque",'mensagem'=>$mensagem,'status'=>$status]);


    }


    


}
