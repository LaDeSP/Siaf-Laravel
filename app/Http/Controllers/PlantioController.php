<?php

namespace App\Http\Controllers;
use App\Models\Plantio;
use App\Models\Propriedade;
use App\Models\Produto;
use App\Models\Talhao;

use Illuminate\Http\Request;

class PlantioController extends Controller
{
    public function index(Request $request){
            //return Plantio::get();
            $this->setPropriedade($request,1);
            $p=$this->getPropriedade($request);
            $tmp = array("propriedade"=> $p, "produtos"=> Produto::all()->where('propriedade_id','=',$p['id']), 'talhao' => Talhao::all()->where('propriedade_id','=',$p['id']));

            return view('plantio', ["User"=>$this->getFirstName($this->usuario['name']) ,'Propriedade'=>$tmp , "Tela"=>"Plantio"]);
    }

    public function create(Request $request){
            return Plantio::create($request);
            return view('plantio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Plantio"]);
    }
}
