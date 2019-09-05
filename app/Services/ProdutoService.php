<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Services\UserService;

class ProdutoService{
    private $userService;
    
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    
    public function index(){
        return $this->userService->propriedadesUser()->produtos()->get();
    }
    
    public function create(array $attributes){
        try {
            $produto = new Produto;
            $produto->nome = $attributes['nome_produto'];
            $produto->plantavel = array_key_exists('plantavel', $attributes) ? 1 : 0;
            $produto->status = 1;
            $produto->propriedade_id = $this->userService->propriedadesUser()->id;
            $produto->unidade_id = $attributes['unidade'];
            $saved = $produto->save();
            if($saved){
                return $data=[
                    'mensagem' => 'Produto salvo com sucesso!',
                    'class' => 'success'
                ];
            }else{
                return $data=[
                    'mensagem' => 'Erro ao salvar produto, tente novamente!',
                    'class' => 'danger'
                ];
            }
        } catch (\Throwable $th) {
            return $data=[
                'mensagem' => 'Erro ao salvar produto, tente novamente!',
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