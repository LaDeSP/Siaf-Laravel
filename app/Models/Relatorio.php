<?php

namespace App\Models;

use DateTime;
use App\Models\Investimento;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Model;

class Relatorio extends Model{
    protected $userService;
    protected $dataRelatorio;
    protected $modelInvestimento;
    
    public function __construct(UserService $userService, Investimento $investimento){
        $this->userService = $userService;
        $this->modelInvestimento = $investimento;
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
        if($request['dates']){
            $this->replaceDataRelatorio($request['dates']);
        }
        $resultadoRelatorio = $this->modelInvestimento->relatorioInvestimentos($this->userService->propriedadesUser(), $this->dataRelatorio);
        return [
            "colunasTabelaHistorico"=> ['Investimento','Data','Quantidade','Valor Unitário R$', 'Total Investimento R$'], /*Array */
            "colunasTabelaResumo"=> ['Total Investido R$',' Total Quantidade'], /*Array */
            "linhasTabelaHistorico"=> $resultadoRelatorio['linhasTabelaHistorico'], /*Array */
            "linhasTabelaResumo"=> $resultadoRelatorio['linhasTabelaResumo'], /*Array */
            "dataRelatorio"=>$this->dataRelatorio,
            "tituloTabelaResumo"=> "Resumo de investimentos",
            "tituloTabelaHistorico"=> "Histórico de investimentos",
            "tituloRelatorio"=> "Relatório de Investimentos",
            "DataEmissaoRelatorio"=> new DateTime()
        ];
    }
}
