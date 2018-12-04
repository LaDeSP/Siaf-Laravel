<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perda;
use App\Models\Destino;
use App\Models\Estoque;


class PerdaController extends Controllers
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Perda $aln)
    {
        $allPerda = $aln->all();
        return compact("allPerda");
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
        $ob =  $request->input('info');
        $perda = ['ID'=> $ob['perda']['id'], 'Quantidade' => $ob['perda']['quantidade'],'Valor' => $ob['perda']['valor_unit'], 'Data' => $ob['perda']['data'], 'Nota' => $ob['perda']['nota'], 'Destino' => $ob['perda']['destino'], 'Estoque' => ['perda']['estoque_id']];
        return response()->json(Perda::inserir($perda));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $perda = Perda::ler($id);
        return $perda;
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
        $perda = Perda::excluir($id);
        return response($perda);
    }	
}