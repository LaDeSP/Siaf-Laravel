<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Estoque;
use App\Models\Produto;
use App\Models\Plantio;
use App\Models\Propriedade;

class Estoque extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Estoque $aln)
    {
        $allVenda = $aln->all();
        return compact("allEstoque");
    }



    public function getProduto()
    {
        $produto = \DB::table('produto')->lists('nome', 'id');
        return view('link.create')->with('produto', $produto);
    }

    public function getPropriedade()
    {
        $produto = \DB::table('propriedade')->lists('nome', 'id');
        return view('link.create')->with('propriedade', $propriedade);
    }

    public function getPlantio()
    {
        $produto = \DB::table('plantio')->lists('data','id');
        return view('link.create')->with('plantio', $plantio);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->getProduto();
        $this->getPlantio();
        $this->getPropriedade();
        return view('estoque');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ob =  $request->input('info');
        $estoque = ['ID'=> $ob['estoque']['id'], 'Quantidade' => $ob['estoque']['quantidade'],'Produto' => $ob['estoque']['produto_id'], 'Data' => $ob['estoque']['data'], 'Propriedade' => $ob['estoque']['propriedade_id'], 'Plantio' => $ob['estoque']['plantio_id']];
        return response()->json(Estoque::inserir($estoque));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $estoque = Estoque::ler($id);
        return $estoque;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $estoque = Estoque::excluir($id);
        return response($estoque);
    }
}
