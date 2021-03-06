<?php
namespace App\Services;

use DateTime;
use App\Models\Estoque;
use App\Models\Produto;
use App\Services\UserService;

class EstoqueService{
    private $userService;
    
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    
    public function index(){
        $estoques =  $this->userService->propriedadesUser()->estoques()->get();
        foreach ($estoques as $estoque) {
            $estoque->quantidade = $this->quantidadeDisponivelDeProdutoEstoque($estoque);
            $estoque->emUso = $this->estoqueEmUso($estoque);
            if($estoque->manejoplantio_id){
                $estoque->plantavel = true;
            }
        }
        return $estoques;
    }

    /*Retorna somente os estoques que tenham quantidade maior que zero*/
    public function indexEstoquesQuantidadeDisponivel(){
        $estoques = $this->userService->propriedadesUser()->estoques()->get();
        $estoquesDisponiveis = [];
        foreach ($estoques as $estoque) {
            $estoque->quantidade = $this->quantidadeDisponivelDeProdutoEstoque($estoque);
            if($estoque->quantidade > 0){
                array_push($estoquesDisponiveis, $estoque);
            }
        }
        return $estoquesDisponiveis;
    }
    
    public function create(array $attributes, $manejo=null){
        try {
            $estoque = new Estoque;
            /*Estoque para colheita de plantio*/
            if($manejo){
                $date = new DateTime();
                $estoque->manejoplantio_id =  $manejo->id;
                $estoque->data = $date->format('Y-m-d H:i:s');
                $estoque->produto_id =  $manejo->plantio()->first()->produto()->first()->id;
            /*Estoque para produto processado*/    
            }else{
                $estoque->produto_id =  Produto::findBySlugOrFail($attributes['produto'])->id;
                $estoque->data = $attributes['data_estoque'];
            }
            $estoque->quantidade = $attributes['quantidade'];
            $estoque->propriedade_id =  $this->userService->propriedadesUser()->id;
            $saved = $estoque->save();
            if($saved){
                if($estoque->manejoplantio_id){
                    return $data=[
                        'mensagem' => 'Colheita adicionada no estoque com sucesso!',
                        'class' => 'success'
                    ];
                }
                return $data=[
                    'mensagem' => 'Estoque salvo com sucesso!',
                    'class' => 'success'
                ];
            }else{
                if($estoque->manejoplantio_id){
                    return $data=[
                        'mensagem' => 'Erro ao salvar colheita no estoque, tente novamente!',
                        'class' => 'danger'
                    ];
                }
                return $data=[
                    'mensagem' => 'Erro ao salvar estoque, tente novamente!',
                    'class' => 'danger'
                ];
            }
        } catch (\Throwable $th) {
            if($estoque->manejoplantio_id){
                return $data=[
                    'mensagem' => 'Erro ao salvar colheita no estoque, tente novamente!',
                    'class' => 'danger'
                ];
            }
            return $data=[
                'mensagem' => 'Erro ao salvar estoque, tente novamente!',
                'class' => 'danger'
            ];
        }
    }
    
    public function update(array $attributes, $estoque){
        try {
            /*Estoque para produto processado*/    
            $estoque->produto_id =  Produto::findBySlugOrFail($attributes['produto'])->id;
            $estoque->data = $attributes['data_estoque'];
            $estoque->quantidade = $attributes['quantidade'];
            $saved = $estoque->update();
            if($saved){
                return $data=[
                    'mensagem' => 'Estoque atualizado com sucesso!',
                    'class' => 'info'
                ];
            }else{
                return $data=[
                    'mensagem' => 'Erro ao atualizar estoque, tente novamente!',
                    'class' => 'danger'
                ];
            }
        } catch (\Throwable $th) {
            return $data=[
                'mensagem' => 'Erro ao atualizar estoque, tente novamente!',
                'class' => 'danger'
            ];
        }
    }
    
    /*Função que calcula a quantidade disponivel do produto estocado*/
    public static function quantidadeDisponivelDeProdutoEstoque($estoque){
        /*Soma todas as quantidades de vendas deste estoque*/
        $quantidadeProdutoVenda = $estoque->vendas()->sum('quantidade');
        
        /*Soma todas as quantidades de perdas deste estoque*/
        $quantidadeProdutoPerdas = $estoque->perdas()->sum('quantidade');
        
        /*Quantidade atual do estoque antes do calculo */
        $quantidadeAtualEstoque = $estoque->getOriginal('quantidade');
        
        /*Calculo para determinar a quantidade do produto no estoque subtraindo da tabela de venda e perda*/
        $novaQuantidadeEstoque = $quantidadeAtualEstoque - ($quantidadeProdutoVenda + $quantidadeProdutoPerdas);
        return $novaQuantidadeEstoque;
    }

    public function estoqueEmUso($estoque){
        if($estoque->perdas()->first() || $estoque->vendas()->first()){
            return true;
        }else{
            return false;
        }
    }
}