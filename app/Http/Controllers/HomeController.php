<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class HomeController extends Controller{
    protected $userService;

    public function __construct(UserService $userService){
        $this->middleware('auth');
        $this->userService = $userService;
    }

    public function index(){
        $propriedade = $this->userService->propriedadesUser();
        return view('painel.dashboard.index', ["propriedade"=>$propriedade]);
    }
}
