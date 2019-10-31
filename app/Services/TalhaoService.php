<?php

namespace App\Services;

use App\Models\Talhao;
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
    
    public function update(array $attributes, $talhao){
        try {
            $talhao->area = $attributes['area_talhao'];
            $talhao->nome = $attributes['nome_talhao'];
            $saved = $talhao->update();
            if($saved){
                return $data=[
                    'mensagem' => 'Talhão atualizado com sucesso!',
                    'class' => 'info'
                ];
            }else{
                return $data=[
                    'mensagem' => 'Erro ao atualizar talhão, tente novamente!',
                    'class' => 'danger'
                ];
            }
        } catch (\Throwable $th) {
            return $data=[
                'mensagem' => 'Erro ao atualizar talhão, tente novamente!',
                'class' => 'danger'
            ];
        }
    }
    
    public function delete($talhao){
        try {
            $status = $talhao->plantios()->first();
            if($status){
                return response()->json(['error'=>'Este talhão já está em uso e não pode ser deletado!']);
            }else{
                $deleted = $talhao->delete();
                if($deleted){
                    return response()->json(['success'=>'Talhão deletado com sucesso!']);
                }else{
                    return response()->json(['error'=>'Erro ao deletar talhão, tente novamente!']);
                }
            }
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Erro ao deletar talhão, tente novamente!']);
        }
    }
}