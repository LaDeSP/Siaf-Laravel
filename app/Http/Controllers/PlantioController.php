<?php

namespace App\Http\Controllers;
use App\Models\Plantio;

use Illuminate\Http\Request;

class PlantioController extends Controller
{
    public function index(){
            return Plantio::get();

            return view('plantio', ["User"=>$this->getFirstName($this->usuario['name']), "Tela"=>"Plantio"]);
    }
}
