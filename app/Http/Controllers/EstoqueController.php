<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use App\Services\EstoqueService;
use App\Services\ProdutoService;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\EstoqueFormRequest;

class EstoqueController extends Controller{
    protected $estoqueService;
    protected $produtoService;

    public function __construct(EstoqueService $estoqueService, ProdutoService $produtoService){
        $this->estoqueService = $estoqueService;
        $this->produtoService = $produtoService;
    }

    public function index(){
        $estoques = $this->estoqueService->index();
        return view('painel.estoques.index', ["estoques" => $estoques]);
    }
    
    public function create(){
        $produtosProcessados = $this->produtoService->index()->where('tipo', 'Processado');
        return view('painel.estoques.create', ['produtos'=>$produtosProcessados]);
    }
    
    public function store(EstoqueFormRequest $request){
        $data = $this->estoqueService->create($request->all());
        if($data['class'] == 'success'){
            return Redirect::route('painel.estoque.index')->with($data['class'], $data['mensagem']);
        }else{
            return back()->with($data['class'], $data['mensagem']);
        }
    }
    
    public function edit(Estoque $estoque){
        $produtosProcessados = $this->produtoService->index()->where('tipo', 'Processado');
        return view('painel.estoques.edit', ['produtos'=>$produtosProcessados, 'estoque'=>$estoque]);
    }
    
    public function update(EstoqueFormRequest $request, Estoque $estoque){
        $data = $this->estoqueService->update($request->all(), $estoque);
        return back()->with($data['class'], $data['mensagem']);
    }
}
