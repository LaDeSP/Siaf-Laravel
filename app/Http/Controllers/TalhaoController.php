<?php

namespace App\Http\Controllers;

use App\Models\Talhao;
use App\Services\TalhaoService;
use App\Http\Requests\TalhaoFormRequest;
use Illuminate\Support\Facades\Redirect;

class TalhaoController extends Controller{
    protected $talhaoService;

    public function __construct(TalhaoService $talhaoService){
        $this->talhaoService = $talhaoService;
    }
    
    public function index(){
        $talhoes = $this->talhaoService->index();
        return view('painel.talhoes.index', ["talhoes" => $talhoes]);
    }
   
    public function create(){
        return view('painel.talhoes.create');
    }

    public function store(TalhaoFormRequest $request){
        $data = $this->talhaoService->create($request->all());
        if($data['class'] == 'success'){
            return Redirect::route('painel.talhao.index')->with($data['class'], $data['mensagem']);
        }else{
            return back()->with($data['class'], $data['mensagem']);
        } 
    }
   
    public function edit(Talhao $talhao){
        return view('painel.talhoes.edit', ['talhao'=>$talhao]);
    }
   
    public function update(TalhaoFormRequest $request, Talhao $talhao){
        $data = $this->talhaoService->update($request->all(), $talhao);
        return back()->with($data['class'], $data['mensagem']);
    }

    public function destroy(Talhao $talhao){
        $data = $this->talhaoService->delete($talhao);
        return $data;
    }
}
