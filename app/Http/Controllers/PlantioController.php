<?php

namespace App\Http\Controllers;
use App\Models\Talhao;
use App\Models\Plantio;
use App\Models\Produto;
use App\Models\Propriedade;
use Illuminate\Http\Request;
use App\Models\ManejoPlantio;
use App\Services\TalhaoService;
use App\Services\PlantioService;

use App\Services\ProdutoService;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
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

    public function index(Request $request,$mensagem='',$status=''){
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
        return back()->with($data['class'], $data['mensagem']);
    }
    
    public function edit(Request $request, Plantio $plantio){
        dd($plantio);
        $talhoes = $this->talhaoService->index();
        $produtos = $this->produtoService->indexProdutosPlantaveis();
        return view('painel.plantios.edit', ['talhoes'=>$talhoes, 'produtos'=>$produtos]);
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
        return redirect()->action('PlantioController@index', ['mensagem'=>$mensagem,'status'=>$status,'page'=>$this->page()]);
    }
    
    public function destroy(Plantio $plantio){
        $data = $this->plantioService->delete($plantio);
        return $data;
    }
    
    
}
