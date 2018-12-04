<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManejoController extends Controller
{
    public function index(){
        return view('manejo', ["User"=>$this->getFirstName($this->usuario['name'])]);
    }
}
