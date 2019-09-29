<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Talhao;
use App\Models\Destino;
use App\Models\Estoque;
use App\Models\Produto;
use Illuminate\Http\Request;
use App\Services\VendaService;

use App\Services\EstoqueService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\VendaFormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;

class VendasController extends Controller{
    protected $vendaService;
    protected $estoqueService;
    
    public function __construct(VendaService $vendaService, EstoqueService $estoqueService){
        $this->vendaService = $vendaService;
        $this->estoqueService = $estoqueService;
    }
    
    public function index(Request $request){
        $vendas = $this->vendaService->index();
        return view('painel.vendas.index', ["vendas" => $vendas]);    
    }
    
    
    public function create(Request $request){
        $destinosVenda = Destino::all()->where('tipo', 1);
        $estoques = $this->estoqueService->indexEstoquesQuantidadeDisponivel();
        return view('painel.vendas.create', ['estoques'=>$estoques, 'destinos'=>$destinosVenda]);        
    }
    
    public function store(VendaFormRequest $request){
        $data = $this->vendaService->create($request->all());
        return back()->with($data['class'], $data['mensagem']);     
    }
    
    
    public function show($id)
    {
        $venda = Venda::ler($id);
        return $venda;
    }
    
    
    public function edit(Request $request, $id)
    {
        $destinos = Venda::destino();
        $propriedade = $this->getPropriedade($request);
        $estoques = Estoque::estoquesPropriedade($propriedade->id);
        $venda = Venda::vendas($propriedade, $id);
        
        foreach ($estoques as $key => $estoque) {
            $estoque->quantidadedisponivel=Estoque::produtosDisponiveis($estoque->id);
        }
        return view('vendaForm', ["User"=>$this->getFirstName($this->usuario['name']), 'Vendas'=>$venda, 'estoques'=>$estoques, 'destinos'=>$destinos, "Tela"=>"Editar Venda" ,'Method'=>'put','Url'=>'/venda'.'/'.$id]);
    }
    
    
    public function update(Request $request, $id)
    {
        $data = array_except($request,['_token'])->toArray();
        $venda = Venda::find($id);
        $data = array_except($request,['id'])->toArray();
        $salva=$venda->update($data);
        if($salva==true)
        {
            $status='success';
            $mensagem='Sucesso ao editar a venda!';
        }
        else
        {
            $status='danger';
            $mensagem='Erro ao editar a venda!';
        }
        
        $propriedade = $this->getPropriedade($request);
        $allVenda = Venda::vendas($propriedade, $id='');
        return redirect()->action('VendasController@index', ['mensagem'=>$mensagem,'status'=>$status,'page'=>$this->page()]);
        
        //return view('venda', ["User"=>$this->getFirstName($this->usuario['name']) ,'Vendas'=>$allVenda , "Tela"=>"Venda",'mensagem'=>$mensagem,'status'=>$status]);
    }
    
    
    public function destroy(Request $request,$id)
    {
        $salva=Venda::where('id',$id)->delete();
        if($salva==true)
        {
            $status='success';
            $mensagem='Sucesso ao excluir a venda!';
        }
        else
        {
            $status='danger';
            $mensagem='Erro ao excluir a venda!';
        }
        
        $propriedade = $this->getPropriedade($request);
        $allVenda = Venda::vendas($propriedade, $id='');
        
        //return view('venda', ["User"=>$this->getFirstName($this->usuario['name']) ,'Vendas'=>$allVenda , "Tela"=>"Plantio",'mensagem'=>$mensagem,'status'=>$status]);
        return redirect()->action('VendasController@index', ['mensagem'=>$mensagem,'status'=>$status,'page'=>$this->page()]);
    }
    
    public function quantidadeProdutoEstoque(Estoque $estoque){
        /*Descriptografa o id do estoque que vem do form*/
            $quantidade = $this->estoqueService->quantidadeDisponivelDeProdutoEstoque($estoque);
            return $quantidade;
        /*Caso alguém altere o hash do id*/
        
    }
}
