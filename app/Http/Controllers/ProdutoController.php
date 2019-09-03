<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Propriedade;
use App\Models\Talhao;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return view('painel.produtos.create');
        $prop = $this->getPropriedade($request);
        return view('produtoForm',["propriedade"=>$prop, "unidades"=>Unidade::all(), "Title"=>"Adicionar produto",'Method'=>'post','Url'=>'/produto']);
    }

    public function store(Request $request){
        if ($request != null) {
            $ret = Produto::insere($request);
            if( $ret == 200){
                $status='success';
                $mensagem='Produto inserido com sucesso!';
            }else{
                $status='danger';
                $mensagem='Ocorreu um erro ao salvar seu produto!';
            }
            $prop = $this->getPropriedade($request);
            $talhao = Talhao::all()->where('propriedade_id','=',$prop['id']) ;
            $produto = Produto::all()->where('propriedade_id','=',$prop['id']);
            foreach ($produto as $p){
                $p['unidade_id'] = DB::table('unidade')->where('id', $p['unidade_id'])->where('unidade.deleted_at','=',null)->value('nome');
            }
            return redirect()->action('PropriedadeController@index', ['mensagem'=>$mensagem,'status'=>$status]);// ["propriedade"=>$prop,"talhao"=>$talhao, "unidades"=>Unidade::get(["id","nome"]),"produto"=>$produto, "User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Propriedade", ]);
        }else{
            return redirect("/propriedades");
        }

    }

    public function show($id){
        return Produto::find($id);
    }

    public function edit(Produto $produto){
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

    public function destroy($id){
        try{
            $p = Produto::find($id);
            if(!$p->estoques()->first() || $p->plantios()->first()){
                $p->delete();
                $status='success';
                $mensagem='Produto removido com sucesso!';
                return redirect()->action('PropriedadeController@index', ['mensagem'=>$mensagem,'status'=>$status, 'produto'=>$this->pageproduto(), 'talhao'=>$this->pagetalhao()]);
            }else
                throw new \Exception();
        }catch (\Exception $e){
            $status='danger';
            $mensagem='Ocorreu um erro ao remover este produto!';
            return redirect()->action('PropriedadeController@index', ['mensagem'=>$mensagem,'status'=>$status]);
        }

    }
}
