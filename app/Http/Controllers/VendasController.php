<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Produto;
use App\Models\Talhao;
use App\Models\Estoque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class VendasController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $propriedade = $this->getPropriedade($request);
        $allVenda = Venda::vendas($propriedade, $id='');
        return view('venda', ["User"=>$this->getFirstName($this->usuario['name']) ,'Vendas'=>$allVenda , "Tela"=>"Venda"]);
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create(Request $request){
        $destinos = Venda::destino();
        $p=$this->getPropriedade($request);
        $estoques = Estoque::estoquesPropriedade($p->id);
        foreach ($estoques as $key => $estoque) {
            $estoque->quantidadedisponivel=Estoque::produtosDisponiveis($estoque->id);
        }
        
        return view('vendaForm', ["User"=>$this->getFirstName($this->usuario['name']), 'estoques'=>$estoques, 'destinos'=>$destinos, "Tela"=>"Adicionar Venda" ,'Method'=>'post','Url'=>'/venda']);
    }
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
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
    
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $venda = Venda::ler($id);
        return $venda;
    }
    
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
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
    
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
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
        return view('venda', ["User"=>$this->getFirstName($this->usuario['name']) ,'Vendas'=>$allVenda , "Tela"=>"Venda",'mensagem'=>$mensagem,'status'=>$status]);
    }
    
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request,$id)
    {
        $salva=Venda::where('id',$id)->delete();
        if($salva==true){
            $status='success';
            $mensagem='Sucesso ao excluir a venda!';
        }
        else{
            $status='danger';
            $mensagem='Erro ao excluir a venda!';
        }
        
        $propriedade = $this->getPropriedade($request);
        $allVenda = Venda::vendas($propriedade, $id='');
        
        return view('venda', ["User"=>$this->getFirstName($this->usuario['name']) ,'Vendas'=>$allVenda , "Tela"=>"Plantio",'mensagem'=>$mensagem,'status'=>$status]);
    }

    public function quantidadeProduto($idEstoque)
    {
        $quantidade = Estoque::produtosDisponiveis($idEstoque);
        return $quantidade;
    }
}
