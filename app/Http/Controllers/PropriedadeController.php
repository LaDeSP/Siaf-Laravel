<?php

namespace App\Http\Controllers;

use App\Models\Plantio;
use App\Models\Produto;
use App\Models\Propriedade;
use Illuminate\Http\Request;

class PropriedadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Propriedade[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(Propriedade $propriedades, Produto $produtos)
    {
        $props = $propriedades->where('users_id', '=', '47110931099');
        $prod  = $produtos->all();
        return view('propriedades', ["propriedades"=>$props, "produtos"=> $prod]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
}
