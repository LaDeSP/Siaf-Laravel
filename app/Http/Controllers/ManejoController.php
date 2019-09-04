<?php

namespace App\Http\Controllers;

use App\Models\Plantio;
use App\Models\Propriedade;
use App\Models\Manejo;
use App\Models\ManejoPlantio;
use App\Models\Talhao;
use App\Models\Estoque;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

use Illuminate\Http\Request;

use App\Services\ManejoService;

class ManejoController extends Controller{
    protected $manejoService;
    
    public function __construct(ManejoService $manejoService){
        $this->manejoService = $manejoService;
    }
    
    public function plantiosManejos(Request $request,$id=''){
        $propiedade=$this->getPropriedade($request);
        if ($id){
            $plantio=array(DB::table('plantio')->join('talhao', 'talhao.id', '=', 'plantio.talhao_id')->join('produto', 'produto.id', '=', 'plantio.produto_id') ->where('plantio.id','=',$id)->where('plantio.deleted_at','=',null)->get(['plantio.id','data_plantio','data_semeadura','quantidade_pantas','talhao_id','produto_id','talhao.nome as nomet','produto.nome as nomep'])->sortByDesc('data_plantio' )  );
            return $plantio[0];
        }
        $talhoes=Talhao::all()->where('propriedade_id','=',$propiedade['id']);
        $plantios = array();
        foreach ($talhoes as $key => $talhao) {
            $plantio=array(DB::table('plantio')->join('talhao', 'talhao.id', '=', 'plantio.talhao_id')->join('produto', 'produto.id', '=', 'plantio.produto_id')->where('plantio.deleted_at','=',null) ->where('talhao_id','=',$talhao['id'])->where('talhao.deleted_at','=',null)->get(['plantio.id','data_plantio','data_semeadura','quantidade_pantas','talhao_id','produto_id','talhao.nome as nomet','produto.nome as nomep'])->sortByDesc('data_plantio' )  );
            foreach ($plantio[0] as $key => $value) {
                $value->manejo=DB::table('manejoplantio')->join('manejo','manejo.id','=','manejo_id')->where('plantio_id','=',$value->id)->where('manejoplantio.deleted_at','=',null)->get(['manejoplantio.id','manejoplantio.descricao','manejoplantio.data_hora','manejoplantio.horas_utilizadas','manejo.nome','manejo.id as manejo_id']);
                foreach ($value->manejo as $key => $val) {
                    
                    if($val->manejo_id==4){
                        $estoque=Estoque::where('manejoplantio_id','=',$val->id)->get(['id'])->first();
                        if(isset($estoque))
                        $val->estoque=$estoque->id;
                    }
                    
                }
                
                array_push($plantios,$value);
            }
            
        }
        //dd($plantios);
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
        $plantios =new Paginator(collect($plantios)->slice($numPagina*$offset),$numPagina,$page);
        return $plantios;
    }
    
    
    public function index(Request $request){
        $plantios = $this->manejoService->index();
        return view('painel.manejos.index', ["plantios" => $plantios]);
    }

    public function showManejosPlantios(Plantio $plantio){
        $this->authorize('view-manejos-plantio', $plantio);
        $manejosPlantio = $this->manejoService->read($plantio);
        if($manejosPlantio->isEmpty()){
            abort(404);            
        }else{
            return view('painel.historicomanejoproduto.index', ["manejos" => $manejosPlantio, "plantio"=>$plantio]);
        }
    }
    
    
    public function create(Request $request, Plantio $plantio){
        return view('painel.historicomanejoproduto.create');
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
        
        //$plantios=$this->plantiosManejos($request,$id='');
        //return view('manejo', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Manejo" ,'Plantios'=>$plantios,'mensagem'=>$mensagem,'status'=>$status ,'Mostrar'=>$manejo->plantio_id,'show'=>'show','disabled'=>'disabled'  ]);
        return redirect()->action('ManejoController@index', ['Mensagem'=>$mensagem,'Status'=>$status,'Mostrar'=>$manejo->plantio_id,'page'=>$this->page()]);
    }
    
    public function edit(Request $request,$manejo){
        $Manejos=Manejo::all();
        $dados=ManejoPlantio::all()->where('id','=',$manejo);
        $dados=$dados->first();
        return view('manejoForm', ["User"=>$this->getFirstName($this->usuario['name']) , "Tela"=>"Editar Manejo" ,'Method'=>'put','Url'=>'manejo/'.$manejo, 'Manejos'=>$Manejos,'dados'=>$dados,'select'=>'selected']);
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
        
        //$plantios=$this->plantiosManejos($request,$id='');
        //return view('manejo', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Manejo" ,'Plantios'=>$plantios,'mensagem'=>$mensagem,'status'=>$status,'Mostrar'=>$Manejo->plantio_id,'show'=>'show' ,'disabled'=>'disabled' ]);
        
        return redirect()->action('ManejoController@index', ['Mensagem'=>$mensagem,'Status'=>$status,'Mostrar'=>$Manejo->plantio_id,'page'=>$this->page()]);
        
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
        //$plantios=$this->plantiosManejos($request,$id='');
        //return view('manejo', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Manejo" ,'Plantios'=>$plantios,'mensagem'=>$mensagem,'status'=>$status,'Mostrar'=>$result->plantio_id ,'show'=>'show','disabled'=>'disabled']);
        return redirect()->action('ManejoController@index', ['Mensagem'=>$mensagem,'Status'=>$status,'Mostrar'=>$result->plantio_id,'page'=>$this->page()]);
    }
    
    public function createEstoque(Request $request,$manejo){
        $Manejos=Manejo::all();
        $dados=ManejoPlantio::all()->where('id','=',$manejo);
        $dados=$dados->first();
        return view('manejoForm', ["User"=>$this->getFirstName($this->usuario['name']) , "Tela"=>"Adicionar ao Estoque" ,'Method'=>'post','Url'=>'manejo/estoque/'.$manejo, 'Manejos'=>$Manejos,'dados'=>$dados ,'select'=>'selected','disabled'=>'disabled' ] );
    }
    
    public function storeEstoque(Request $request,$manejo){
        $result=ManejoPlantio::where('id','=',$manejo)->get(['id as manejoplantio_id','data_hora as data','plantio_id'])->first();
        $result->quantidade=$request->numero_produdos;
        $plantio=Plantio::where('id','=',$result->plantio_id)->get()->first();
        $result->produto_id=$plantio->produto_id;
        $result->propriedade_id=$propiedade=$this->getPropriedade($request)->id;
        $result=$result->toArray();
        $estoque = new Estoque($result);
        $salva=$estoque->save();
        
        if($salva==true){
            $status='success';
            $mensagem='Sucesso ao salvar estoque do manejo!';
        }
        else{
            $status='danger';
            $mensagem='Erro ao salvar estoque do manejo!';
        }
        //$plantios=$this->plantiosManejos($request,$id='');
        //return view('manejo', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Manejo" ,'Plantios'=>$plantios,'mensagem'=>$mensagem,'status'=>$status,'Mostrar'=>$result['plantio_id'] ,'show'=>'show' ,'disabled'=>'disabled']);
        return redirect()->action('ManejoController@index', ['Mensagem'=>$mensagem,'Status'=>$status,'Mostrar'=>$result['plantio_id'],'page'=>$this->page()]);
    }
    
    
    
}
