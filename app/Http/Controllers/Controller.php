<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Propriedade;
use Illuminate\Support\Facades\Auth;
use function PHPSTORM_META\type;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    function __construct() {
        $this->middleware(function ($request, $next) {
            $this->usuario = Auth::user();


            if (! $request->session()->exists('propriedade') || $request->session()->get('propriedade')==null ) {
                  $request->session()->put('propriedade',array_first(Propriedade::all()->where('users_id', '=', $this->usuario['cpf'])));

            }

            return $next($request);
        });
    }

    function  setPropriedade($request,$id){

       $request->session()->put('propriedade', array_first( Propriedade::all()->where('users_id', '=', $this->usuario['cpf'])->where('id', '=', $id ) ));

    }

    function  getPropriedade($request){
      return $request->session()->get('propriedade');


    }

    function getFirstName($name){
        $name = trim($name);
        preg_match('/[^\s]*/', $name, $matches);
        return $matches[0];
    }




}
