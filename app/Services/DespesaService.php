<?php
namespace App\Services;

use App\Models\Despesa;
use Illuminate\Http\Request;
use App\Services\UserService;

class DespesaService{
    private $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    
    public function index(){
        return $this->userService->propriedadesUser()->despesas()->get();
    }

    public function create(array $attributes){
        try {
            $despesa = new Despesa;
            $despesa->nome = $attributes['despesa'];
            $despesa->descricao =  $attributes['descricao'];
            $despesa->valor_unit = $attributes['valor_despesa'];
            $despesa->quantidade =  $attributes['quantidade'];
            $despesa->data =  $attributes['data_despesa'];
            $despesa->propriedade_id = $this->userService->propriedadesUser()->id;
            $saved = $despesa->save();
            if($saved){
                return $data=[
                    'mensagem' => 'Despesa salva com sucesso!',
                    'class' => 'success'
                ];
            }else{
                return $data=[
                    'mensagem' => 'Erro ao salvar despesa, tente novamente!',
                    'class' => 'danger'
                ];
            }
        } catch (\Throwable $th) {
            return $data=[
                'mensagem' => 'Erro ao salvar despesa, tente novamente!',
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