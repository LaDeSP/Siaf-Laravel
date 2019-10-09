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
        $produtos = $this->userService->propriedadesUser()->produtos()->get();
        foreach ($produtos as $produto) {
            if($produto->tipo == "c_permanente"){
                $produto->tipo = "Permanente";
            }if($produto->tipo == "c_temporaria"){
                $produto->tipo = "Temporário";
            }else{
                $produto->tipo = "Processado";
            }
            $produto->emUso = $this->verificaProdutoEmUso($produto);
        }
        return $produtos;
    }

    /*Retona todos os produtos plantaveis para criação de um plantio */
    public function indexProdutosPlantaveis(){
        return $this->userService->propriedadesUser()->produtos()->whereIn("tipo", ["c_permanente","c_temporaria"])->get();
    }
    
    public function create(array $attributes){
        try {
            $produto = new Produto;
            $produto->nome = title_case($attributes['nome_produto']);
            if($attributes['categoria'] == 'processado'){
                $produto->tipo = 'processado';
            }else if($attributes['categoria'] == 'c_permanente'){
                $produto->tipo = 'c_permanente';
            }else{
                $produto->tipo = 'c_temporaria';
            }
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
    
    public function delete($produto){
        try {
            if($this->verificaProdutoEmUso($produto)){
                return response()->json(['error'=>'Este produto já está em uso e não pode ser deletado!']);
            }else{
                $deleted = $produto->delete();
                if($deleted){
                    return response()->json(['success'=>'Produto deletado com sucesso!']);
                }else{
                    return response()->json(['error'=>'Erro ao deletar produto, tente novamente!']);
                }
            }
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Erro ao deletar produto, tente novamente!']);
        }
    }

    public function verificaProdutoEmUso($produto){
        if($produto->estoques()->first() || $produto->plantios()->first()){
            return true;
        }else{
            return false;
        }
    }
}