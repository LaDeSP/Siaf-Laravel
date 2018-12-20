<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Investimento;

class InvestimentoController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $propriedade = $this->getPropriedade($request);
        $investimento = Investimento::ler('propriedade_id', $propriedade->id);
        if(!$investimento)
            return redirect()->action('InvestimentoController@index', ['mensagem'=>$request->mensagem,'status'=>$request->status,'page'=>$this->page()-1]);
        return view('investimento',["propriedade" => $propriedade,"dados" => $investimento, "User"=>$this->getFirstName($this->usuario['name']),"Tela" =>"Investimentos"]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request != null) {
            $investimento = Investimento::insere($request->all());
            if($investimento == 200){
                $status='success';
                $mensagem='Sucesso ao salvar o investimento!';
            }else{
                $status='danger';
                $mensagem='Erro ao salvar o investimento!';
            }
            $propriedade = $this->getPropriedade($request);
            $investimento = Investimento::ler('propriedade_id', $propriedade->id);
            //return view('investimento',["propriedade" => $propriedade,"dados" => $investimento, "User"=>$this->getFirstName( $this->usuario['nome']) , "Tela"=>"Investimentos",'mensagem'=>$mensagem,'status'=>$status]);
            return redirect()->action('InvestimentoController@index', ['mensagem'=>$mensagem,'status'=>$status,'page'=>$this->page()]);
        }else{
            return 405;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Investimento  $investimento
     * @return \Illuminate\Http\Response
     */
    public function show($id= null,$variable=null)
    {
        return Investimento::ler($id, $variable);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Investimento  $investimento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request != null) {
            $investimento = Investimento::alterar($request, $id);
            if($investimento == 200){
                $status='success';
                $mensagem='Sucesso ao editar o investimento!';
            }else{
                $status='danger';
                $mensagem='Erro ao editar o investimento!';
            }
            $propriedade = $this->getPropriedade($request);
            $investimento = Investimento::ler('propriedade_id', $propriedade->id);
            return redirect()->action('InvestimentoController@index', ['mensagem'=>$mensagem,'status'=>$status,'page'=>$this->page()]);
            //return view('investimento', ["propriedade" => $propriedade,"dados" => $investimento, "User"=>$this->getFirstName($this->usuario['name']),"Tela" =>"Investimentos",'mensagem'=>$mensagem,'status'=>$status]);
        }else{
            return 405;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Investimento  $investimento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if ($id != null) {
            $investimento = Investimento::excluir($id);
            if($investimento == 200){
                $status='success';
                $mensagem='Sucesso ao excluir o investimento!';
            }else{
                $status='danger';
                $mensagem='Erro ao excluir o investimento!';
            }
            $propriedade = $this->getPropriedade($request);
            $investimento = Investimento::ler('propriedade_id', $propriedade->id);
            //return view('investimento',["propriedade" => $propriedade,"dados" => $investimento, "User"=>$this->getFirstName($this->usuario['name']) , "Tela"=>"Investimentos",'mensagem'=>$mensagem,'status'=>$status]);
            return redirect()->action('InvestimentoController@index', ['mensagem'=>$mensagem,'status'=>$status,'page'=>$this->page()]);
        }
        return 405;
    }
}
