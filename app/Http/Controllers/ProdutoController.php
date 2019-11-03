<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Unidade;
use App\Services\ProdutoService;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProdutoFormRequest;

class ProdutoController extends Controller{
    protected $produtoService;
    
    public function __construct(ProdutoService $produtoService){
        $this->produtoService = $produtoService;
    }
    
    public function index(){
        $produtos = $this->produtoService->index();
        return view('painel.produtos.index', ["produtos" => $produtos]);
    }
    
    public function create(){
        return view('painel.produtos.create', ["unidades"=>Unidade::all()]);
    }
    
    public function store(ProdutoFormRequest $request){
        $data = $this->produtoService->create($request->all());
        if($data['class'] == 'success'){
            return Redirect::route('painel.produto.index')->with($data['class'], $data['mensagem']);
        }else{
            return back()->with($data['class'], $data['mensagem']);
        } 
    }
    
    public function edit(Produto $produto){
        $categoriasProduto = array("processado","c_permanente","c_temporaria");
        return view('painel.produtos.edit', ["unidades"=>Unidade::all(), "produto"=>$produto, "categorias"=>$categoriasProduto]);
    }
    
    public function update(ProdutoFormRequest $request, Produto $produto){
        $data = $this->produtoService->update($request->all(), $produto);
        return back()->with($data['class'], $data['mensagem']);
    }
    
    public function destroy(Produto $produto){
        $data = $this->produtoService->delete($produto);
        return $data; 
    }
}
