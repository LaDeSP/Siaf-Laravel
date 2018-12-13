<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Propriedade;
use App\Models\Talhao;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropriedadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Propriedade[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request)
    {
        $prop = $this->getPropriedade($request);
        $talhao = Talhao::all()->where('propriedade_id','=',$prop['id']) ;
        $produto = Produto::all()->where('propriedade_id','=',$prop['id']);
        foreach ($produto as $p){
            $p['unidade_id'] = DB::table('unidade')->where('id', $p['unidade_id'])->value('nome');
        }
        return view('propriedades', ["propriedade"=>$prop,"talhao"=>$talhao, "produto"=>$produto, "User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Propriedade"]);
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
        return Propriedade::all()->where('users_id', '=', $id);
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
