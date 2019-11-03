<?php

namespace App\Http\Controllers;

use App\Models\Plantio;
use App\Services\TalhaoService;
use App\Services\PlantioService;
use App\Services\ProdutoService;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\PlantioFormRequest;

class PlantioController extends Controller{
    protected $plantioService;
    protected $talhaoService;
    protected $produtoService;

    public function __construct(PlantioService $plantioService, TalhaoService $talhaoService, ProdutoService $produtoService){
        $this->plantioService = $plantioService;
        $this->talhaoService = $talhaoService;
        $this->produtoService = $produtoService;
    }

    public function index(){
        $plantios = $this->plantioService->index();
        return view('painel.plantios.index', ["plantios" => $plantios]);
    }
    
    public function create(){
        $talhoes = $this->talhaoService->index();
        $produtos = $this->produtoService->indexProdutosPlantaveis();
        return view('painel.plantios.create', ['talhoes'=>$talhoes, 'produtos'=>$produtos]);    
    }

    public function store(PlantioFormRequest $request){
        $data = $this->plantioService->create($request->all());
        if($data['class'] == 'success'){
            return Redirect::route('painel.plantio.index')->with($data['class'], $data['mensagem']);
        }else{
            return back()->with($data['class'], $data['mensagem']);
        }
    }
    
    public function edit(Plantio $plantio){
        $talhoes = $this->talhaoService->index();
        $produtos = $this->produtoService->indexProdutosPlantaveis();
        return view('painel.plantios.edit', ['talhoes'=>$talhoes, 'produtos'=>$produtos, 'plantio'=>$plantio]);
    }
    
    public function update(PlantioFormRequest $request, Plantio $plantio){
        $data = $this->plantioService->update($request->all(), $plantio);
        return back()->with($data['class'], $data['mensagem']);
    }
    
    public function destroy(Plantio $plantio){
        $data = $this->plantioService->delete($plantio);
        return $data;
    }
}
