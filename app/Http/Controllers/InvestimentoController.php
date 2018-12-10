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
    public function index(Request  $request)
    {
        $this->setPropriedade($request,1);
        $propriedade = $this->getPropriedade($request);
        $investimento = Investimento::ler('propriedade_id', $propriedade->id);
        
        return view('investimento',["propriedade" => $propriedade,"dados" => $investimento, "User"=>$this->getFirstName($this->usuario['name']),"Tela" =>"Investimento"]);
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
            return Investimento::insere($request->all());
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
            return Investimento::alterar($request, $id);
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
    public function destroy($id)
    {
        if ($id != null) {
            return  Investimento::excluir($id);
        }
        return 405;
    }
}
