<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class home extends Controller
{
  public function login()
{
  return view('login');
}

public function autentica(Request $request)
{
    $all = $request->all();
    dd($all);
}

public function novo()
{
  return view('novo');
}

public function salva(Request $request)
{
  $all = $request->all();
  dd($all);
}



}
