<?php

namespace App\Services;

use App\Repositories\TalhaoRepository;
use App\Models\Talhao;
use Illuminate\Http\Request;
use App\Services\UserService;

class TalhaoService{
    private $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    
    public function index(){
        return $this->userService->propriedadesUser()->talhoes()->get();
    }
    
    public function create(array $attributes){
        try {
            $talhao = new Talhao;
            $talhao->area = $attributes['area_talhao'];
            $talhao->nome = $attributes['nome_talhao'];
            $talhao->propriedade_id = $this->userService->propriedadesUser()->id;
            $saved = $talhao->save();
            if($saved){
                return $data=[
                    'mensagem' => 'Talhão salvo com sucesso!',
                    'class' => 'success'
                ];
            }else{
                return $data=[
                    'mensagem' => 'Erro ao salvar talhão, tente novamente!',
                    'class' => 'danger'
                ];
            }
        } catch (\Throwable $th) {
            return $data=[
                'mensagem' => 'Erro ao salvar talhão, tente novamente!',
                'class' => 'danger'
            ];
        }    
    }
    
    public function read($id){
        return $this->talhaoRepository->find($id);
    }

    public function readPlantioTalhao($idTalhao){
        return $this->talhaoRepository->findPlantioTalhao($idTalhao);
    }
    
    public function update(Request $request, $id){
        $attributes = $request->all();
        return $this->talhaoRepository->update($id, $attributes);
    }
    
    public function delete($id){
        return $this->talhaoRepository->delete($id);
    }
}