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
        $this->setPropriedade($request,1);
        $propriedade = $this->getPropriedade($request);
        $despesas = Despesa::ler('propriedade_id', $propriedade->id);
        return view('despesa', ["propriedade" => $propriedade, "dados" => $despesas,"User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Despesas"]);
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
            return Despesa::inserir($request->all());
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
            return Despesa::alterar($request, $id);
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
    public function destroy($id)
    {
        if ($id != null) {
            return  Despesa::excluir($id);
        }
        return 405;
    }
}
