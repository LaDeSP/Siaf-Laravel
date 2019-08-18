<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Propriedade;
use App\Models\Talhao;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $prop = $this->getPropriedade($request);
//        dd($prop);
        return view('produtoForm',["propriedade"=>$prop, "unidades"=>Unidade::all(), "Title"=>"Adicionar produto",'Method'=>'post','Url'=>'/produto']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    public function store(Request $request)
    {
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Produto::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produto = Produto::find($id);
        $prop = Propriedade::find($produto['propriedade_id']);
        return view('produtoForm',["propriedade"=>$prop, "produto"=>$produto, "munidade"=> $produto['unidade_id'], "unidades"=>Unidade::all(),'Method'=>'put','Url'=>'/produto'.'/'.$id, "Title"=>"Editar produto"]);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
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
