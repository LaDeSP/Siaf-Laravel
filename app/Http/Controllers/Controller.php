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
            if (! $request->session()->exists('propriedade')) {
                $propriedade=array_first(Propriedade::all()->where('users_id', '=', $this->usuario['cpf']));
                $request->session()->put('propriedade_id',$propriedade);

            }

            return $next($request);
        });
    }

    function  setPropriedade($request,$id){
       $propriedade=array_first( Propriedade::all()->where('users_id', '=', $this->usuario['cpf'],'id', '=', $id ) );
       $request->session()->put('propriedade', $propriedade);

    }

    function  getPropriedade($request){
      return $request->session()->get('propriedade');


    }

    function getFirstName($name){
        $name = trim($name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );
        return $first_name;
    }

}
