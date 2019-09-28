<?php

namespace App\Http\Controllers;

use App\Models\Perda;
use App\Models\Talhao;
use App\Models\Estoque;
use App\Models\Plantio;
use App\Models\Produto;
use App\Models\Propriedade;
use Illuminate\Http\Request;
use App\Models\ManejoPlantio;
use App\Services\EstoqueService;
use App\Services\ProdutoService;

use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\EstoqueFormRequest;

class EstoqueController extends Controller{
    protected $estoqueService;
    protected $produtoService;

    public function __construct(EstoqueService $estoqueService, ProdutoService $produtoService){
        $this->estoqueService = $estoqueService;
        $this->produtoService = $produtoService;
    }
    
    public function estoquePlataveisIndex(){
        $estoquePlantaveis = $this->estoqueService->estoquePlataveisIndex();
        return view('painel.estoques.indexPlantaveis', ["estoques" => $estoquePlantaveis]);
    }

    public function estoqueProcessadoIndex(){
        $estoquePropriedade = $this->estoqueService->estoqueProcessadoIndex();
        return view('painel.estoques.indexNaoPlantaveis', ["estoques" => $estoquePropriedade]);
    }
    
    public function index(Request $request)
    {
        $propriedade=$this->getPropriedade($request);
        $Estoques = Estoque::estoquesPropriedade($propriedade->id);
        
        foreach ($Estoques as $key => $Estoque) {
            $Estoque->disponivel=Estoque::produtosDisponiveis($Estoque->id);
        }
        
        $Estoques=$Estoques->filter(function ($value, $key){
            return $value->disponivel!=0;
        });
        $numPagina=8;
        if(isset($request['page'])){
            $page=$request['page'];
            if($page>0)
            $offset=$page-1;
            else {
                $offset=0;
            }
            
        }
        else {
            $offset=0;
            $page=1;
        }
        if( sizeof($Estoques) <= $numPagina*$offset && $page>1){
            
            $offset--;
            $page--;
            return redirect()->action('EstoqueController@index', ['mensagem'=>$request->mensagem,'status'=>$request->status,'page'=>$page ] );
        }
        $Estoques = new Paginator($Estoques->slice($numPagina*$offset),$numPagina,$page);
        
        
        return view('estoque', ["User"=>$this->getFirstName($this->usuario['name']) ,'Estoques'=>$Estoques , "Tela"=>"Estoque", 'mensagem'=>$request->mensagem,'status'=>$request->status]);
        
        
    }
    
    public function create(){
        $produtosProcessados = $this->produtoService->index()->where('tipo', 'Processado');
        return view('painel.estoques.create', ['produtos'=>$produtosProcessados]);
    }
    
    public function store(EstoqueFormRequest $request){
        $data = $this->estoqueService->create($request->all());
        return back()->with($data['class'], $data['mensagem']);

        $post = array_except($request,['_token'])->toArray();
        $plantio = new Estoque($post);
        $salva=$plantio->save();
        if($salva==true){
            $status='success';
            $mensagem='Sucesso ao salvar o Estoque!';
        }
        else{
            $status='danger';
            $mensagem='Erro ao salvar o Estoque!';
        }
        return redirect()->action('EstoqueController@index', ['mensagem'=>$mensagem,'status'=>$status]);
        
    }
    
    public function edit(Request $request,$id){
        $propriedade=$this->getPropriedade($request);
        $produtos=Produto::all()->where('propriedade_id','=',$propriedade['id'])->where('plantavel','=',0);
        $tmp = array("propriedade"=> $propriedade, "produto"=>$produtos  );
        $dados=Estoque::where('id','=',$id)->get()->first();
        return view('estoqueForm', ["User"=>$this->getFirstName($this->usuario['name']) ,'Propriedade'=>$tmp , "Tela"=>"Adicionar Estoque" ,'Method'=>'put','Url'=>'/estoque/'.$id,'dados'=>$dados]);
        
    }
    
    
    public function update(Request $request,$id){
        $post = array_except($request,['_token'])->toArray();
        $post=array_except($request,['_method'])->toArray();
        $post = array_except($request,['id'])->toArray();
        $estoque = Estoque::where('id','=',$id)->first();
        $salva=$estoque->update($post);
        if($salva==true){
            $status='success';
            $mensagem='Sucesso ao editar o Estoque!';
        }
        else{
            $status='danger';
            $mensagem='Erro ao editar o Estoque!';
        }
        
        return redirect()->action('EstoqueController@index', ['mensagem'=>$mensagem,'status'=>$status,'page'=>$this->page()]);
    }
    
    public function destroy(Request $request,$id){
        $salva=Estoque::where('id',$id)->delete();
        if($salva==true){
            $status='success';
            $mensagem='Sucesso ao excluir o Estoque!';
        }
        else{
            $status='danger';
            $mensagem='Erro ao excluir o Estoque!';
        }
        
        return redirect()->action('EstoqueController@index', ['mensagem'=>$mensagem,'status'=>$status,'page'=>$this->page()]);
    }
    
    
}
