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

    public function page(){
      $query=parse_url(url()->previous());
      if(isset($query['query'])){
        $page=explode('page',$query['query']);
        if(isset($page[1] )){
          $page=explode('=',$page[1]);
            if(isset($page[1]))
              return $page[1];
          }
        }
      return 0;

    }

    public function pageproduto(){
      $query=parse_url(url()->previous());
      if(isset($query['query'])){
        $page=explode('produto',$query['query']);
        if(isset($page[1] )){
          $page=explode('&',$page[1]);
          if(isset($page[1])){
            $page=explode('=',$page[1]);
          }else{
            $page=explode('=',$page[0]);
          }
            if(isset($page[1]))
              return $page[1];
          }
        }
      return 0;
    }

    public function pagetalhao(){
      $query=parse_url(url()->previous());
      if(isset($query['query'])){
        $page=explode('talhao',$query['query']);
        if(isset($page[1] )){
          $page=explode('&',$page[1]);
          if(isset($page[1])){
            $page=explode('=',$page[1]);
          }else{
            $page=explode('=',$page[0]);
          }
            if(isset($page[1]))
              return $page[1];
          }
        }
      return 0;
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
