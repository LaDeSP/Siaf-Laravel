<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estoque;
use App\Models\Produto;
use App\Models\Talhao;
use App\Models\Plantio;
use App\Models\Propriedade;
use App\Models\ManejoPlantio;
use App\Models\Perda;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;


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

          $Estoques=$Estoques->filter(function ($value, $key){
                return $value->disponivel!=0;
              });
          $numPagina=8;
          if(isset($request['page'])){
            $page=$request['page'];
            if($page>0)
              $offset=$page-1;
            else {
              $offset=0;
            }

          }
          else {
            $offset=0;
            $page=1;
          }
          if( sizeof($Estoques) <= $numPagina*$offset){
            $offset--;
            $page--;
          }
        $Estoques = new Paginator($Estoques->slice($numPagina*$offset),$numPagina,$page);

        return view('estoque', ["User"=>$this->getFirstName($this->usuario['name']) ,'Estoques'=>$Estoques , "Tela"=>"Estoque", 'mensagem'=>$request->mensagem,'status'=>$request->status]);


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
      return redirect()->action('EstoqueController@index', ['mensagem'=>$mensagem,'status'=>$status]);

    }

public function edit(Request $request,$id){
  $propriedade=$this->getPropriedade($request);
  $produtos=Produto::all()->where('propriedade_id','=',$propriedade['id'])->where('plantavel','=',0);
  $tmp = array("propriedade"=> $propriedade, "produto"=>$produtos  );
  $dados=Estoque::where('id','=',$id)->get()->first();
  return view('estoqueForm', ["User"=>$this->getFirstName($this->usuario['name']) ,'Propriedade'=>$tmp , "Tela"=>"Adicionar Estoque" ,'Method'=>'put','Url'=>'/estoque/'.$id,'dados'=>$dados]);

}


public function update(Request $request,$id){
        $post = array_except($request,['_token'])->toArray();
        $post=array_except($request,['_method'])->toArray();
        $post = array_except($request,['id'])->toArray();
        $estoque = Estoque::where('id','=',$id)->first();
        $salva=$estoque->update($post);
        if($salva==true){
          $status='success';
          $mensagem='Sucesso ao editar o Estoque!';
        }
        else{
          $status='danger';
          $mensagem='Erro ao editar o Estoque!';
        }

        return redirect()->action('EstoqueController@index', ['mensagem'=>$mensagem,'status'=>$status,'page'=>$this->page()]);
      }

      public function destroy(Request $request,$id){
                      $salva=Estoque::where('id',$id)->delete();
                      if($salva==true){
                        $status='success';
                        $mensagem='Sucesso ao excluir o Estoque!';
                      }
                      else{
                        $status='danger';
                        $mensagem='Erro ao excluir o Estoque!';
                      }

                      return redirect()->action('EstoqueController@index', ['mensagem'=>$mensagem,'status'=>$status,'page'=>$this->page()]);
      }


}
