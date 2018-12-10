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

    public function plantios(Request $request){
      $propiedade=$this->getPropriedade($request);
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
            $this->setPropriedade($request,1);
            $p=$this->getPropriedade($request);
            $tmp = array("propriedade"=> $p, "produto"=> Produto::all()->where('propriedade_id','=',$p['id']), 'talhao' => Talhao::all()->where('propriedade_id','=',$p['id']));
            return view('plantioForm', ["User"=>$this->getFirstName($this->usuario['name']) ,'Propriedade'=>$tmp , "Tela"=>"Plantio" ,'Method'=>'post','Url'=>'/plantio']);
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

            return view('plantio', ["User"=>$this->getFirstName($this->usuario['name']) ,'Plantios'=>$plantios , "Tela"=>"Plantio",'mensagem'=>'Sucesso ao salvar o usuario!','status'=>'success']);

    }

    public function update(Request $request,$id){
            $post = array_except($request,['_token'])->toArray();
            $plantio = Plantio::find($id);
            $post = array_except($request,['id'])->toArray();
            $plantio->update($post);
            return $plantio ;
          }
    public function destroy(Request $request,$id){
                    $res=Plantio::where('id',$id)->delete();
                    return $res ;
    }

}
