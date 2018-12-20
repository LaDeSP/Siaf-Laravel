<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Despesa;

class DespesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $propriedade = $this->getPropriedade($request);
        $despesas = Despesa::ler('propriedade_id', $propriedade->id);
        if(!$despesas)
          return redirect()->action('DespesaController@index', ['mensagem'=>$request->mensagem,'status'=>$request->status,'page'=>$this->page()-1]);  
        return view('despesa', ["propriedade" => $propriedade, "dados" => $despesas,"User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Despesas",'mensagem'=>$request->mensagem,'status'=>$request->status]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $propriedade = $this->getPropriedade($request);
            $despesa =  Despesa::inserir($request->all());
            $despesas = Despesa::ler('propriedade_id', $propriedade->id);
            if ($despesa == 200) {
                $status='success';
                $mensagem='Sucesso ao salvar a despesa!';
            }else{
                $status='danger';
                $mensagem='Sucesso ao salvar a despesa';
            }
            return redirect()->action('DespesaController@index', ['mensagem'=>$mensagem,'status'=>$status]);
        }else{
            return 405;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id=null,$variable=null)
    {
        return Despesa::ler($id, $variable);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        if ($request != null) {
            $propriedade = $this->getPropriedade($request);
            $despesa =  Despesa::alterar($request, $id);
            $despesas = Despesa::ler('propriedade_id', $propriedade->id);
            if ($despesa == 200) {
                $status='success';
                $mensagem='Sucesso ao editar a despesa!';
            }else{
                $status='danger';
                $mensagem='Sucesso ao editar a despesa';
            }
            return redirect()->action('DespesaController@index', ['mensagem'=>$mensagem,'status'=>$status,'page'=>$this->page()]);
        }else{
            return 405;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($id != null) {
            $propriedade = $this->getPropriedade($request);
            $despesa =  Despesa::excluir($id);
            $despesas = Despesa::ler('propriedade_id', $propriedade->id);
            if ($despesa == 200) {
                $status='success';
                $mensagem='Sucesso ao excluir a despesa!';
            }else{
                $status='danger';
                $mensagem='Sucesso ao excluir a despesa';
            }
            return redirect()->action('DespesaController@index', ['mensagem'=>$mensagem,'status'=>$status,'page'=>$this->page()]);
            //return view('despesa', ["propriedade" => $propriedade, "dados" => $despesas,"User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Despesas", "status" => $status, "mensagem" => $mensagem]);
        }
        return 405;
    }
}
