<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cidade;
use App\Models\Propriedade;

class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $propiedades=Propriedade::all()->where('users_id','=',$this->usuario['cpf']);
        $propiedade=array_first($propiedades) ;
        $cidade=Cidade::cordenadas($propiedade['cidade_id']);

        return view('welcome',["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Início",'Longitude'=> $cidade['longitude'],"Latitude" => $cidade['latitude']]);
    }
}
