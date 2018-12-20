<?php

namespace App\Http\Controllers;

use App\Models\Propriedade;
use App\Models\Talhao;
use Illuminate\Http\Request;

class TalhaoController extends Controller
{
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
        return view('talhaoForm',["propriedade"=>$prop, "Title"=>"Adicionar talhão",'Method'=>'post','Url'=>'/talhao']);
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
            $ret = Talhao::inserir($request);
            if( $ret == 200){
                $status='success';
                $mensagem='Talhão inserido com sucesso!';
            }else{
                $status='danger';
                $mensagem='Ocorreu um erro ao salvar seu talhão!';
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
        return Talhao::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $talhao = Talhao::find($id);
        $prop = Propriedade::find($talhao['propriedade_id']);
        return view('talhaoForm',["propriedade"=>$prop, "talhao"=>$talhao, 'Method'=>'put','Url'=>'/talhao'.'/'.$id, "Title"=>"Editar Talhão"]);

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
            $ret = Talhao::atualizar($request, $id);
            if( $ret == 200){
                $status='success';
                $mensagem='Talhão atualizado com sucesso!';
            }else{
                $status='danger';
                $mensagem='Ocorreu um erro ao atualizar este talhão!';
            }
            return redirect()->action('PropriedadeController@index', ['mensagem'=>$mensagem,'status'=>$status, 'talhao'=>$this->pagetalhao(), 'produto'=>$this->pageproduto()]);// ["propriedade"=>$prop,"talhao"=>$talhao, "unidades"=>Unidade::get(["id","nome"]),"produto"=>$produto, "User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Propriedade", ]);
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
            $t = Talhao::find($id);
            if(!PropriedadeController::findUsageT($t)){
                $t->delete();
                $status='success';
                $mensagem='Talhão removido com sucesso!';
                return redirect()->action('PropriedadeController@index', ['mensagem'=>$mensagem,'status'=>$status, 'talhao'=>$this->pagetalhao(), 'produto'=>$this->pageproduto()]);
            }else
                throw new \Exception();
        }catch (\Exception $e){
            $status='danger';
            $mensagem='Ocorreu um erro ao remover este Talhão!';
            return redirect()->action('PropriedadeController@index', ['mensagem'=>$mensagem,'status'=>$status]);
        }

    }
}
