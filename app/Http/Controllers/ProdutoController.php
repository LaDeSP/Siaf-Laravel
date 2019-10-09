<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Propriedade;
use App\Models\Talhao;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProdutoFormRequest;

use App\Services\ProdutoService;

class ProdutoController extends Controller{
    protected $produtoService;
    
    public function __construct(ProdutoService $produtoService){
        $this->produtoService = $produtoService;
    }
    
    public function index(){
        $produtos = $this->produtoService->index();
        return view('painel.produtos.index', ["produtos" => $produtos]);
    }
    
    public function create(Request $request){
        return view('painel.produtos.create', ["unidades"=>Unidade::all()]);
    }
    
    public function store(ProdutoFormRequest $request){
        $data = $this->produtoService->create($request->all());
        return back()->with($data['class'], $data['mensagem']); 
    }
    
    public function show($id){
        return Produto::find($id);
    }
    
    public function edit(Produto $produto){
        dd($produto->id);
        //$produto = Produto::find($id);
        //$prop = Propriedade::find($produto['propriedade_id']);
        $this->authorize('update-produto', $produto);
        dd($produto);
        return view('produtoForm',["propriedade"=>$prop, "produto"=>$produto, "munidade"=> $produto['unidade_id'], "unidades"=>Unidade::all(),'Method'=>'put','Url'=>'/produto'.'/'.$id, "Title"=>"Editar produto"]);
    }
    
    public function update(Request $request, $id){
        if ($request != null and $id != null) {
            $ret = Produto::atualizar($request, $id);
            if( $ret == 200){
                $status='success';
                $mensagem='Produto atualizado com sucesso!';
            }else{
                $status='danger';
                $mensagem='Ocorreu um erro ao atualizar este produto!';
            }
            $prop = $this->getPropriedade($request);
            $talhao = Talhao::all()->where('propriedade_id','=',$prop['id']) ;
            $produto = Produto::all()->where('propriedade_id','=',$prop['id']);
            foreach ($produto as $p){
                $p['unidade_id'] = DB::table('unidade')->where('id', $p['unidade_id'])->where('unidade.deleted_at','=',null)->value('nome');
            }
            return redirect()->action('PropriedadeController@index', ['mensagem'=>$mensagem,'status'=>$status, 'produto'=>$this->pageproduto(), 'talhao'=>$this->pagetalhao()]);// ["propriedade"=>$prop,"talhao"=>$talhao, "unidades"=>Unidade::get(["id","nome"]),"produto"=>$produto, "User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Propriedade", ]);
        }else{
            return redirect()->action('PropriedadeController@index');
        }
    }
    
    public function destroy(Produto $produto){
        $data = $this->produtoService->delete($produto);
        return $data; 
    }
}
