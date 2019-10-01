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

use App\Services\EstoqueService;
use App\Services\PlantioService;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\ManejoFormRequest;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\EstoqueFormRequest;
use App\Http\Requests\ColheitaFormRequest;

class ManejoController extends Controller{
    protected $manejoService;
    protected $plantioService;
    protected $estoqueService;
    
    public function __construct(ManejoService $manejoService, PlantioService $plantioService, EstoqueService $estoqueService){
        $this->manejoService = $manejoService;
        $this->plantioService= $plantioService;
        $this->estoqueService= $estoqueService;
    }
    
    public function index(Request $request){
        $plantios = $this->manejoService->plantios();
        return view('painel.manejos.index', ["plantios" => $plantios]);
    }

    public function showManejosPlantios(Plantio $plantio){
        $this->authorize('view-manejos-plantio', $plantio);
        $manejosPlantio = $this->manejoService->read($plantio);

        /*Quando for para view, somente os manejos colheitas terão o botão de colheita desabilitado quando quantidade for igual a zero*/
        if($plantio->produto()->first()->tipo == "c_temporaria"){
            $plantio->quantidade_pantas = $this->plantioService->novaQuantidadePlantio($plantio);
        }
        /*Caso o plantio não tenha manejos*/
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
        if($data['class'] == 'success'){
            return Redirect::route('painel.manejosPlantios', ['plantio'=>$plantio])->with($data['class'], $data['mensagem']);
        }else{
            return back()->with($data['class'], $data['mensagem']);
        }
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
        $data = $this->estoqueService->create($request->all(), $manejo);
        /*Caso não ocorra nenhum problema no estoque de plantio*/
        if($data['class'] == 'success'){
            return Redirect::route('painel.manejosPlantios', ['plantio'=>$manejo->plantio()->first()])->with($data['class'], $data['mensagem']);
        }else{
            return back()->with($data['class'], $data['mensagem']);
        }
    }
    
    
    
}
