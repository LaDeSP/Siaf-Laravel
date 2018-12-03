<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Propriedade;
use App\Models\Talhao;
use Illuminate\Http\Request;

class PropriedadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Propriedade[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        $props = Propriedade::all()->where('users_id', '=', '47110931099');
        $props_prod = [];
        foreach ($props as $p){
            $tmp = array("propriedade"=> $p, "produtos"=> Produto::all()->where('propriedade_id','=',$p['id']), 'talhao' => Talhao::all()->where('propriedade_id','=',$p['id']));
            $props_prod[]= $tmp;
        }
        return view('propriedades', ["propriedades"=>$props_prod,"User"=>$this->usuario]);
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