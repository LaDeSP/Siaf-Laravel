<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Destino;
use App\Models\Estoque;
use App\Services\VendaService;
use App\Services\EstoqueService;
use App\Http\Requests\VendaFormRequest;
use Illuminate\Support\Facades\Redirect;

class VendasController extends Controller{
    protected $vendaService;
    protected $estoqueService;
    
    public function __construct(VendaService $vendaService, EstoqueService $estoqueService){
        $this->vendaService = $vendaService;
        $this->estoqueService = $estoqueService;
    }
    
    public function index(){
        $vendas = $this->vendaService->index();
        return view('painel.vendas.index', ["vendas" => $vendas]);    
    }
    
    public function create(){
        $destinosVenda = Destino::all()->where('tipo', 1);
        $estoques = $this->estoqueService->indexEstoquesQuantidadeDisponivel();
        return view('painel.vendas.create', ['estoques'=>$estoques, 'destinos'=>$destinosVenda]);        
    }
    
    public function store(VendaFormRequest $request){
        $data = $this->vendaService->create($request->all());
        if($data['class'] == 'success'){
            return Redirect::route('painel.venda.index')->with($data['class'], $data['mensagem']);
        }else{
            return back()->with($data['class'], $data['mensagem']);
        }    
    }
    
    public function edit(Venda $venda){
        $destinosVenda = Destino::all()->where('tipo', 1);
        $quantidadeEstoqueVendaAtual = $this->quantidadeProdutoEstoque($venda->estoque()->first());
        return view('painel.vendas.edit', ['estoque'=>$venda->estoque()->first()->produto()->first()->nome,'quantidadeEstoqueAtual'=>$quantidadeEstoqueVendaAtual, 'destinos'=>$destinosVenda, 'venda'=>$venda]);
    }
    
    public function update(VendaFormRequest $request, Venda $venda){
        $data = $this->vendaService->update($request->all(), $venda);
        return back()->with($data['class'], $data['mensagem']);
    }
    
    public function destroy(Venda $venda){
        $data = $this->vendaService->delete($venda);
        return $data;
    }
    
    public function quantidadeProdutoEstoque(Estoque $estoque){
        $quantidade = $this->estoqueService->quantidadeDisponivelDeProdutoEstoque($estoque);
        return $quantidade;
    }
}
