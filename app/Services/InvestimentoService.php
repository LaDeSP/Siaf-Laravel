<?php
namespace App\Services;

use App\Models\Investimento;
use Illuminate\Http\Request;
use App\Services\UserService;

class InvestimentoService{
    private $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    
    public function index(){
        return $this->userService->propriedadesUser()->investimentos()->get();
    }

    public function create(array $attributes){
        try {
            $investimento = new Investimento;
            $investimento->nome = $attributes['investimento'];
            $investimento->descricao =  $attributes['descricao'];
            $investimento->valor_unit = $attributes['valor_investimento'];
            $investimento->quantidade =  $attributes['quantidade'];
            $investimento->data =  $attributes['data_investimento'];
            $investimento->propriedade_id = $this->userService->propriedadesUser()->id;
            $saved = $investimento->save();
            if($saved){
                return $data=[
                    'mensagem' => 'Investimento salvo com sucesso!',
                    'class' => 'success'
                ];
            }else{
                return $data=[
                    'mensagem' => 'Erro ao salvar investimento, tente novamente!',
                    'class' => 'danger'
                ];
            }
        } catch (\Throwable $th) {
            return $data=[
                'mensagem' => 'Erro ao salvar investimento, tente novamente!',
                'class' => 'danger'
            ];
        }
    }
    
    public function read($id){
        //return $this->propriedadeRepository->find($id);
    }
    
    public function update(Request $request, $id){
    }

    public function delete($id){
    }
}