<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Investimento;
use App\Models\Propriedade;
class InvestimentoController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('investimento',['method' => 'get', "User"=>$this->getFirstName($this->usuario['name'])]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $objeto=$request->all();
        if(!(isset ($objeto['propriedade_id']))){
            $prop = Propriedade::find(1);
            $objeto['propriedade_id'] = $prop->id;
        }
        if ($request != null) {
            $investimento = Investimento::insere($objeto);
            if (!(empty($investimento))) {
                return redirect()->action('InvestimentoController@index');
            }
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
    public function show(Investimento $investimento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Investimento  $investimento
     * @return \Illuminate\Http\Response
     */
    public function edit(Investimento $investimento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Investimento  $investimento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Investimento $investimento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Investimento  $investimento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Investimento $investimento)
    {
        //
    }
}
