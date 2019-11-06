<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use App\Models\Estoque;
use App\Models\Plantio;
use App\Services\PerdaService;
use App\Services\EstoqueService;
use App\Services\PlantioService;
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
    
    public function createPerdaEstoque(Estoque $estoque){
        $destinosPerda = Destino::all()->where('tipo', 0);
        $estoque->quantidade = $this->estoqueService->quantidadeDisponivelDeProdutoEstoque($estoque);
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
        if($quantidadeEstoque == 0){
            return Redirect::route('painel.estoque.index')->with($data['class'], $data['mensagem']);
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
            if($data['class'] == 'success'){
                return Redirect::route('painel.plantio.index')->with($data['class'], $data['mensagem']);
            }else{
                return back()->with($data['class'], $data['mensagem']);
            }
        }
    } 
}
