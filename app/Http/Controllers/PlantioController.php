<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlantioController extends Controller
{
    public function index(){
        return view('plantio', ["User"=>$this->getFirstName($this->usuario['name'])]);
    }
}
