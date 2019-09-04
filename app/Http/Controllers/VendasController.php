<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Produto;
use App\Models\Talhao;
use App\Models\Estoque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Services\VendaService;
class VendasController extends Controller{
    protected $vendaService;

    public function __construct(VendaService $vendaService){
        $this->vendaService = $vendaService;
    }

    public function index(Request $request){
        $vendas = $this->vendaService->index();
        return view('painel.vendas.index', ["vendas" => $vendas]);
        
        $propriedade = $this->getPropriedade($request);
        $allVenda = Venda::vendas($propriedade, $id='');
        //dd([$allVenda->currentPage(), $this->page(),$allVenda->currentPage()< $this->page(),$allVenda,Venda::mudou() ]);

        if( !$allVenda )
              return redirect()->action('VendasController@index', ['mensagem'=>$request->mensagem,'status'=>$request->status,'page'=>$request->page-1]);

        return view('venda', ["User"=>$this->getFirstName($this->usuario['name']) ,'vendas'=>$allVenda , "Tela"=>"Venda",'mensagem'=>$request->mensagem,'status'=>$request->status]);
    }

    
    public function create(Request $request){
        return view('painel.vendas.create');
        $destinos = Venda::destino();
        $p=$this->getPropriedade($request);
        $estoques = Estoque::estoquesPropriedade($p->id);
        foreach ($estoques as $key => $estoque) {
            $estoque->quantidadedisponivel=Estoque::produtosDisponiveis($estoque->id);
        }

        return view('vendaForm', ["User"=>$this->getFirstName($this->usuario['name']), 'estoques'=>$estoques, 'destinos'=>$destinos, "Tela"=>"Adicionar Venda" ,'Method'=>'post','Url'=>'/venda']);
    }

    
    public function store(Request $request)
    {
        $data = $request->all();
        $venda = new Venda($data);
        $salva=$venda->save();
        if($salva==true)
        {
            $status='success';
            $mensagem='Sucesso ao salvar a venda!';
        }
        else
        {
            $status='danger';
            $mensagem='Erro ao salvar a venda!';
        }

        $propriedade = $this->getPropriedade($request);
        $allVenda = Venda::vendas($propriedade, $id='');
        return view('venda', ["User"=>$this->getFirstName($this->usuario['name']) ,'Vendas'=>$allVenda , "Tela"=>"Venda",'mensagem'=>$mensagem,'status'=>$status]);

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

    public function quantidadeProduto($idEstoque)
    {
        $quantidade = Estoque::produtosDisponiveis($idEstoque);
        return $quantidade;
    }
}
