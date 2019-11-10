<?php

namespace App\Models;

use DateTime;
use App\Models\Investimento;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Model;

class Relatorio extends Model{
    protected $userService;
    protected $colunasTabelaHistorico;
    protected $colunasTabelaResumo;
    protected $linhasTabelaHistorico;
    protected $linhasTabelaResumo;
    protected $dataRelatorio;
    
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    public function replaceDataRelatorio($datas){
        $datas = explode("até", $datas);
        $dataInicio = trim($datas[0]);
        $dataFim = trim($datas[1]);
        $dataInicio =  strtotime($datas[0]);
        $dataFim =  strtotime($datas[1]);
        $dataInicio = date("Y-d-m", $dataInicio);
        $dataFim = date("Y-d-m", $dataFim);
        $this->dataRelatorio = ['dataInicio'=>$dataInicio, 'dataFim'=>$dataFim];
    }
    
    public function investimentos(array $request){
        $this->replaceDataRelatorio($request['dates']);
        $this->colunasTabelaHistorico = ['Investimento','Data','Quantidade','Valor Unitário R$', 'Total Investimento R$'];
        $this->colunasTabelaResumo= ['Total Investido R$',' Total Quantidade'];
        $this->linhasTabelaHistorico = $this->userService->propriedadesUser()->investimentos()->groupBy('id')
                        ->orderBy('created_at', 'desc')
                        ->whereBetween('data', [$this->dataRelatorio['dataInicio'], $this->dataRelatorio['dataFim']])
                        ->selectRaw('nome as \'1\', data as \'2\', quantidade as \'3\', valor_unit as \'4\', sum(valor_unit*quantidade) as \'5\'')
                        ->get();
        $linhasTabelaResumo = $this->userService->propriedadesUser()->investimentos()->groupBy('id')
                        ->orderBy('created_at', 'desc')
                        ->whereBetween('data', [$this->dataRelatorio['dataInicio'], $this->dataRelatorio['dataFim']])
                        ->selectRaw('sum(valor_unit*quantidade) as \'1\'')
                        ->selectRaw('sum(quantidade) as \'2\'')
                        ->get();
        $this->linhasTabelaResumo = ['1' =>$linhasTabelaResumo->sum('1'), '2'=>$linhasTabelaResumo->sum('2')];
        return [
            "colunasTabelaHistorico"=>$this->colunasTabelaHistorico, /*Array */
            "colunasTabelaResumo"=>$this->colunasTabelaResumo, /*Array */
            "linhasTabelaHistorico"=> $this->linhasTabelaHistorico, /*Array */
            "linhasTabelaResumo"=>$this->linhasTabelaResumo, /*Array */
            "dataRelatorio"=>$this->dataRelatorio,
            "tituloTabelaResumo"=> "Resumo de investimentos",
            "tituloTabelaHistorico"=> "Histórico de investimentos",
            "tituloRelatorio"=> "Relatório de Investimentos",
            "DataEmissaoRelatorio"=> new DateTime()
        ];
    }
}
