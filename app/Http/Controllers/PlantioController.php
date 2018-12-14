<?php

namespace App\Http\Controllers;
use App\Models\Plantio;
use App\Models\Propriedade;
use App\Models\Produto;
use App\Models\Talhao;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class PlantioController extends Controller
{
    public function index(Request $request,$mensagem='',$status=''){
            //return Plantio::get();

            $plantios=$this->plantios($request);
            return view('plantio', ["User"=>$this->getFirstName($this->usuario['name']) ,'Plantios'=>$plantios , "Tela"=>"Plantio"]);

    }

    public function plantios(Request $request,$id=''){
      $propiedade=$this->getPropriedade($request);
      if ($id){
        $plantio=array(DB::table('plantio')->join('talhao', 'talhao.id', '=', 'plantio.talhao_id')->join('produto', 'produto.id', '=', 'plantio.produto_id') ->where('plantio.id','=',$id)->get(['plantio.id','data_plantio','data_semeadura','quantidade_pantas','talhao_id','produto_id','talhao.nome as nomet','produto.nome as nomep'])->sortByDesc('data_plantio' )  );
        return $plantio[0];
      }
      $talhoes=Talhao::all()->where('propriedade_id','=',$propiedade['id']);
      $plantios = array();
      foreach ($talhoes as $key => $talhao) {
          $plantio=array(DB::table('plantio')->join('talhao', 'talhao.id', '=', 'plantio.talhao_id')->join('produto', 'produto.id', '=', 'plantio.produto_id') ->where('talhao_id','=',$talhao['id'])->get(['plantio.id','data_plantio','data_semeadura','quantidade_pantas','talhao_id','produto_id','talhao.nome as nomet','produto.nome as nomep'])->sortByDesc('data_plantio' )  );
          foreach ($plantio[0] as $key => $value) {
            array_push($plantios,$value);
          }

        }
        return $plantios;
    }

    public function create(Request $request){
            $p=$this->getPropriedade($request);
            $tmp = array("propriedade"=> $p, "produto"=> Produto::all()->where('propriedade_id','=',$p['id'])->where('plantavel','=',1), 'talhao' => Talhao::all()->where('propriedade_id','=',$p['id']));
            return view('plantioForm', ["User"=>$this->getFirstName($this->usuario['name']) ,'Propriedade'=>$tmp , "Tela"=>"Adicionar Plantio" ,'Method'=>'post','Url'=>'/plantio']);
    }

    public function edit(Request $request,$id){
      $dados=$this->plantios($request,$id);
      $p=$this->getPropriedade($request);
      $tmp = array("propriedade"=> $p, "produto"=> Produto::all()->where('propriedade_id','=',$p['id'])->where('plantavel','=',1), 'talhao' => Talhao::all()->where('propriedade_id','=',$p['id']));
      return view('plantioForm', ["User"=>$this->getFirstName($this->usuario['name']) ,'Propriedade'=>$tmp , "Tela"=>"Editar Plantio" ,'Method'=>'put','Url'=>'/plantio/'.$id ,'dados'=>$dados[0] ] );
    }



    public function store(Request $request){
            $post = array_except($request,['_token'])->toArray();
            $plantio = new Plantio($post);
            $salva=$plantio->save();
            if($salva==true){
              $status='success';
              $mensagem='Sucesso ao salvar o plantio!';
            }
            else{
              $status='danger';
              $mensagem='Erro ao salvar o plantio!';
            }
            $plantios=$this->plantios($request);

            return view('plantio', ["User"=>$this->getFirstName($this->usuario['name']) ,'Plantios'=>$plantios , "Tela"=>"Plantio",'mensagem'=>$mensagem,'status'=>$status]);

    }

    public function update(Request $request,$id){
            $post = array_except($request,['_token'])->toArray();
            $plantio = Plantio::find($id);
            $post = array_except($request,['id'])->toArray();
            $salva=$plantio->update($post);
            if($salva==true){
              $status='success';
              $mensagem='Sucesso ao editar o plantio!';
            }
            else{
              $status='danger';
              $mensagem='Erro ao editar o plantio!';
            }

            $plantios=$this->plantios($request);

            return view('plantio', ["User"=>$this->getFirstName($this->usuario['name']) ,'Plantios'=>$plantios , "Tela"=>"Plantio",'mensagem'=>$mensagem,'status'=>$status]);
          }

    public function destroy(Request $request,$id){
                    $salva=Plantio::where('id',$id)->delete();
                    if($salva==true){
                      $status='success';
                      $mensagem='Sucesso ao excluir o plantio!';
                    }
                    else{
                      $status='danger';
                      $mensagem='Erro ao excluir o plantio!';
                    }

                    $plantios=$this->plantios($request);

                    return view('plantio', ["User"=>$this->getFirstName($this->usuario['name']) ,'Plantios'=>$plantios , "Tela"=>"Plantio",'mensagem'=>$mensagem,'status'=>$status]);
    }

}
