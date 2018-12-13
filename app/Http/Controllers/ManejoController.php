<?php
/*

|        | POST      | manejo               | manejo.store   | App\Http\Controllers\ManejoController@store   | web,auth,Closure |
|        | GET|HEAD  | manejo               | manejo.index   | App\Http\Controllers\ManejoController@index   | web,auth,Closure |
|        | GET|HEAD  | manejo/create        | manejo.create  | App\Http\Controllers\ManejoController@create  | web,auth,Closure |
|        | DELETE    | manejo/{manejo}      | manejo.destroy | App\Http\Controllers\ManejoController@destroy | web,auth,Closure |
|        | PUT|PATCH | manejo/{manejo}      | manejo.update  | App\Http\Controllers\ManejoController@update  | web,auth,Closure |
|        | GET|HEAD  | manejo/{manejo}      | manejo.show    | App\Http\Controllers\ManejoController@show    | web,auth,Closure |
|        | GET|HEAD  | manejo/{manejo}/edit | manejo.edit    | App\Http\Controllers\ManejoController@edit    | web,auth,Closure |


*/




namespace App\Http\Controllers;

use App\Models\Plantio;
use App\Models\Propriedade;
use App\Models\Manejo;
use App\Models\ManejoPlantio;
use App\Models\Talhao;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;


class ManejoController extends Controller
{

  public function plantiosManejos(Request $request,$id=''){
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
          $value->manejo=DB::table('manejoplantio')->join('manejo','manejo.id','=','manejo_id')->where('plantio_id','=',$value->id)->get(['manejoplantio.id','manejoplantio.descricao','manejoplantio.data_hora','manejoplantio.horas_utilizadas','manejo.nome','manejo.id as manejo_id']);
          array_push($plantios,$value);
        }

      }
      return $plantios;
  }


    public function index(Request $request,$mensagem='',$status=''){
        $plantios=$this->plantiosManejos($request,$id='');
        //return $plantios;
        return view('manejo', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Manejo" ,'Plantios'=>$plantios  ]);
    }


    public function create(Request $request,$plantio){
      $Manejos=Manejo::all();
      return view('manejoForm', ["User"=>$this->getFirstName($this->usuario['name']) ,'Plantio'=>$plantio , "Tela"=>"Adicionar Manejo" ,'Method'=>'post','Url'=>'/manejo', 'Manejos'=>$Manejos]);
    }


    public function store(Request $request){
      $post = array_except($request,['_token'])->toArray();
      $manejo = new ManejoPlantio($post);
      $salva=$manejo->save();
      if($salva==true){
        $status='success';
        $mensagem='Sucesso ao salvar o manejo!';
      }
      else{
        $status='danger';
        $mensagem='Erro ao salvar o manejo!';
      }

      $plantios=$this->plantiosManejos($request,$id='');
      return view('manejo', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Manejo" ,'Plantios'=>$plantios,'mensagem'=>$mensagem,'status'=>$status ,'Mostrar'=>$manejo->plantio_id,'show'=>'show'  ]);
    }

    public function edit(Request $request,$manejo){
      $Manejos=Manejo::all();
      $dados=ManejoPlantio::all()->where('id','=',$manejo);
      $dados=$dados->first();
      return view('manejoForm', ["User"=>$this->getFirstName($this->usuario['name']) , "Tela"=>"Adicionar Manejo" ,'Method'=>'put','Url'=>'manejo/'.$manejo, 'Manejos'=>$Manejos,'dados'=>$dados,'select'=>'selected']);
    }

    public function update(Request $request,$manejo){
//      return $request;
      $Manejo = ManejoPlantio::find($manejo);

      $post = array_except($request,['_token'])->toArray();
      $post = array_except($request,['id'])->toArray();
      $salva=$Manejo->update($post);
      if($salva==true){
        $status='success';
        $mensagem='Sucesso ao editar o manejo!';
      }
      else{
        $status='danger';
        $mensagem='Erro ao editar o manejo!';
      }

      $plantios=$this->plantiosManejos($request,$id='');
      return view('manejo', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Manejo" ,'Plantios'=>$plantios,'mensagem'=>$mensagem,'status'=>$status,'Mostrar'=>$Manejo->plantio_id,'show'=>'show'  ]);

    }

    public function destroy(Request $request,$manejo){
          $result=ManejoPlantio::find($manejo);
          $salva=ManejoPlantio::where('id',$manejo)->delete();
          if($salva==true){
            $status='success';
            $mensagem='Sucesso ao excluir o manejo!';
            }
          else{
              $status='danger';
              $mensagem='Erro ao excluir o manejo!';
              }
          $plantios=$this->plantiosManejos($request,$id='');
          return view('manejo', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Manejo" ,'Plantios'=>$plantios,'mensagem'=>$mensagem,'status'=>$status,'Mostrar'=>$result->plantio_id ,'show'=>'show']);
    }

  public function createEstoque(Request $request,$manejo){
    $Manejos=Manejo::all();
    $dados=ManejoPlantio::all()->where('id','=',$manejo);
    $dados=$dados->first();
    return view('manejoForm', ["User"=>$this->getFirstName($this->usuario['name']) , "Tela"=>"Adicionar ao Estoque" ,'Method'=>'post','Url'=>'manejo/estoque/'.$manejo, 'Manejos'=>$Manejos,'dados'=>$dados ,'select'=>'selected','disabled'=>'disabled' ] );
  }

  public function storeEstoque(Request $request,$manejo){

        $result=ManejoPlantio::where('id','=',$manejo)->get(['id','data_hora','plantio_id']);
        $result[0]->numero_produdos=$request->numero_produdos;

        return $result;


        if($salva==true){
          $status='success';
          $mensagem='Sucesso ao excluir o manejo!';
          }
        else{
            $status='danger';
            $mensagem='Erro ao excluir o manejo!';
            }
        $plantios=$this->plantiosManejos($request,$id='');
        return view('manejo', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Manejo" ,'Plantios'=>$plantios,'mensagem'=>$mensagem,'status'=>$status,'Mostrar'=>$result->plantio_id ,'show'=>'show']);
  }





}
