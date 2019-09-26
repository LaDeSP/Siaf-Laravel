<?php

namespace App\Http\Controllers;

use App\Models\Manejo;
use App\Models\Talhao;
use App\Models\Estoque;
use App\Models\Plantio;
use App\Models\Propriedade;
use Illuminate\Http\Request;
use App\Models\ManejoPlantio;
use App\Services\ManejoService;

use App\Services\PlantioService;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\ManejoFormRequest;
use App\Http\Requests\EstoqueFormRequest;
use App\Http\Requests\ColheitaFormRequest;

class ManejoController extends Controller{
    protected $manejoService;
    protected $plantioService;
    
    public function __construct(ManejoService $manejoService, PlantioService $plantioService){
        $this->manejoService = $manejoService;
        $this->plantioService= $plantioService;
    }
    
    public function index(Request $request){
        $plantios = $this->manejoService->plantios();
        return view('painel.manejos.index', ["plantios" => $plantios]);
    }

    public function showManejosPlantios(Plantio $plantio){
        $this->authorize('view-manejos-plantio', $plantio);
        $manejosPlantio = $this->manejoService->read($plantio);
        $plantio->quantidade_pantas = $this->plantioService->novaQuantidadePlantio($plantio);
        if($manejosPlantio->isEmpty()){
            abort(404);            
        }else{
            return view('painel.historicomanejoproduto.index', ["manejos" => $manejosPlantio, "plantio"=>$plantio]);
        }
    }
    
    public function create(Plantio $plantio){
        $this->authorize('view-manejos-plantio', $plantio);
        $manejos = $this->manejoService->index();
        return view('painel.historicomanejoproduto.create', ["manejos"=>$manejos, "plantio"=>$plantio]);
    }
    
    
    public function store(ManejoFormRequest $request, Plantio $plantio){
        $data = $this->manejoService->create($request->all(), $plantio);
        return back()->with($data['class'], $data['mensagem']);
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
    
    public function createEstoqueColheitaManejo(Request $request, ManejoPlantio $manejo){
        $manejos = $this->manejoService->index();
        $plantio = $manejo->plantio()->first();
        $plantio->quantidade_pantas = $this->plantioService->novaQuantidadePlantio($plantio);
        $plantio->produto = $plantio->produto()->first()->tipo == 'c_temporaria' ? $plantio->produto="c_temporaria" : $plantio->produto="c_permanente";
        return view('painel.historicomanejoproduto.create-estoque-colheita', ["manejos" => $manejos, 'manejo'=>$manejo, 'plantio'=>$plantio]);
    }
    
    public function storeEstoqueColheitaManejo(ColheitaFormRequest $request, ManejoPlantio $manejo){
        dd($request->all());
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
