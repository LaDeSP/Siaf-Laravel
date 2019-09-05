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
    
    public function plantios(Request $request,$id=''){
        $propiedade=$this->getPropriedade($request);
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
        
        if ($id){
            $plantio=array(DB::table('plantio')->join('talhao', 'talhao.id', '=', 'plantio.talhao_id')->join('produto', 'produto.id', '=', 'plantio.produto_id') ->where('plantio.id','=',$id)->where('plantio.deleted_at','=',null)->get(['plantio.id','data_plantio','data_semeadura','quantidade_pantas','talhao_id','produto_id','talhao.nome as nomet','produto.nome as nomep'])->sortByDesc('data_plantio' )  );
            return $plantio[0];
        }
        $talhoes=Talhao::where('propriedade_id','=',$propiedade['id'])->pluck('id')->toArray();
        
        $plantios=array(DB::table('plantio')
        ->join('talhao', 'talhao.id', '=', 'plantio.talhao_id')
        ->join('produto', 'produto.id', '=', 'plantio.produto_id')
        ->whereIn('talhao_id',$talhoes)
        ->where('plantio.deleted_at','=',null)
        ->get([
            'plantio.id',
            'data_plantio',
            'data_semeadura',
            'quantidade_pantas',
            'talhao_id',
            'produto_id',
            'talhao.nome as nomet',
            'produto.nome as nomep'
            ]
            )
            ->sortByDesc('data_plantio' )
        );
        
        foreach ($plantios[0] as $key => $value) {
            $manejopalantio=ManejoPlantio::where('plantio_id','=',$value->id)->get(['id'])->first();
            if(isset($manejopalantio))
            $value->manejopalantio=$manejopalantio->id;
            
        }
        if( sizeof($plantios[0]) <= $numPagina*$offset && $page>1){
            $offset--;
            $page--;
            return redirect()->action('PlantioController@index', ['mensagem'=>$request->mensagem,'status'=>$request->status,'page'=>$page]);
            
        }
        
        $paginator = new Paginator($plantios[0]->slice($numPagina*$offset),$numPagina,$page);
        return $paginator;
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
    
    public function edit(Request $request,$id){
        $dados=$this->plantios($request,$id);
        $p=$this->getPropriedade($request);
        $tmp = array("propriedade"=> $p, "produto"=> Produto::all()->where('propriedade_id','=',$p['id'])->where('plantavel','=',1), 'talhao' => Talhao::all()->where('propriedade_id','=',$p['id']));
        return view('plantioForm', ["User"=>$this->getFirstName($this->usuario['name']) ,'Propriedade'=>$tmp , "Tela"=>"Editar Plantio" ,'Method'=>'put','Url'=>'/plantio/'.$id ,'dados'=>$dados[0] ] );
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
        
        //$plantios=$this->plantios($request);
        //return view('plantio', ["User"=>$this->getFirstName($this->usuario['name']) ,'Plantios'=>$plantios , "Tela"=>"Plantio",'mensagem'=>$mensagem,'status'=>$status]);
        
        
        return redirect()->action('PlantioController@index', ['mensagem'=>$mensagem,'status'=>$status,'page'=>$this->page()] );
        
    }
    
    
    public function destroy(Request $request,$id){
        $salva=Plantio::where('id',$id)->delete();
        if($salva==true){
            $status='success';
            $mensagem='Sucesso ao excluir o plantio!';
        }
        else{
            $status='danger';
            $mensagem='Erro ao excluir o plantio!';
        }
        
        //$plantios=$this->plantios($request);
        //return view('plantio', ["User"=>$this->getFirstName($this->usuario['name']) ,'Plantios'=>$plantios , "Tela"=>"Plantio",'mensagem'=>$mensagem,'status'=>$status]);
        return redirect()->action('PlantioController@index', ['mensagem'=>$mensagem,'status'=>$status,'page'=>$this->page()]);
    }
    
    
}
