<?php

namespace App\Http\Controllers;
use App\Models\Plantio;
use App\Models\Propriedade;
use App\Models\Produto;
use App\Models\Talhao;

use Illuminate\Http\Request;

class PlantioController extends Controller
{
    public function index(){
            //return Plantio::get();
            $props =  Propriedade::all()->where('users_id', '=', $this->usuario['cpf']);
            $props_prod = [];
            foreach ($props as $p){
                $tmp = array("propriedade"=> $p, "produtos"=> Produto::all()->where('propriedade_id','=',$p['id']), 'talhao' => Talhao::all()->where('propriedade_id','=',$p['id']));
                $props_prod[]= $tmp;
            }


            
            return view('plantio', ["User"=>$this->getFirstName($this->usuario['name']) ,'Propriedades'=>$props_prod , "Tela"=>"Plantio"]);
    }

    public function create(Request $request){
            return Plantio::create($request);

            return view('plantio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Plantio"]);
    }
}
