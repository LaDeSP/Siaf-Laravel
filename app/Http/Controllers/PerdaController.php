<?php

namespace App\Http\Controllers;

use App\Models\Perda;
use App\Models\Talhao;
use App\Models\Destino;
use App\Models\Estoque;
use App\Models\Plantio;
use App\Models\Produto;
use App\Models\Propriedade;
use Illuminate\Http\Request;
use App\Models\ManejoPlantio;
use App\Services\PerdaService;
use App\Services\EstoqueService;
use App\Services\PlantioService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\PerdaEstoqueFormRequest;
use App\Http\Requests\PerdaPlantioFormRequest;



class PerdaController extends Controller{
    protected $plantioService;
    protected $perdaService;
    protected $estoqueService;

    public function __construct(PlantioService $plantioService, PerdaService $perdaService, EstoqueService $estoqueService){
        $this->plantioService = $plantioService;
        $this->perdaService = $perdaService;
        $this->estoqueService = $estoqueService;
    }
    
    public function index(Request $request){
    }
    
    public function createPerdaEstoque(Estoque $estoque){
        $destinosPerda = Destino::all()->where('tipo', 0);
        return view('painel.estoques.create-perda', ['estoque'=>$estoque, 'destinos'=>$destinosPerda]);
    }

    public function createPerdaPlantio(Plantio $plantio){
        $destinosPerda = Destino::all()->where('tipo', 0);
        $plantio->quantidade_pantas = $this->plantioService->novaQuantidadePlantio($plantio);
        return view('painel.plantios.create-perda', ['plantio'=>$plantio, 'destinos'=>$destinosPerda]);
    }

    public function storePerdaEstoque(PerdaEstoqueFormRequest $request, Estoque $estoque){    
        $data = $this->perdaService->create($request->all(), $plantio=null, $estoque);
        $quantidadeEstoque = $this->estoqueService->quantidadeDisponivelDeProdutoEstoque($estoque);
        $tipoProduto = $estoque->produto->first()->tipo;
        if($quantidadeEstoque == 0){
            if($tipoProduto == 'c_temporaria' || $tipoProduto == 'c_permanente'){
                return Redirect::route('painel.estoquePlantaveis')->with($data['class'], $data['mensagem']);
            }else{
                return Redirect::route('painel.estoqueProcessado')->with($data['class'], $data['mensagem']);
            }
        }else{
            return back()->with($data['class'], $data['mensagem']);
        }    
    }
    
    public function storePerdaPlantio(PerdaPlantioFormRequest $request, Plantio $plantio){
        $data = $this->perdaService->create($request->all(), $plantio);
        $quantidade_plantas = $this->plantioService->novaQuantidadePlantio($plantio);
        if($quantidade_plantas == 0){
            return Redirect::route('painel.plantio.index')->with($data['class'], $data['mensagem']);
        }else{
            return back()->with($data['class'], $data['mensagem']);
        }
    }
    
    public function page(){
        $query=parse_url(url()->previous());
        if(isset($query['query'])){
            $page=explode('page',$query['query']);
            if(isset($page[1] )){
                $page=explode('=',$page[1]);
                if(isset($page[1]))
                return $page[1];
            }
        }
        return 0;
        
    }
    
}
