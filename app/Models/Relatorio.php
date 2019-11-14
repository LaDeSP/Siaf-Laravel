<?php

namespace App\Models;

use DateTime;
use App\Models\Despesa;
use App\Models\Plantio;
use App\Models\Investimento;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Model;

class Relatorio extends Model{
    protected $userService;
    protected $dataRelatorio;
    protected $modelInvestimento;
    protected $modelDespesa;
    protected $modelPlantio;
    
    public function __construct(UserService $userService, Investimento $investimento, Despesa $despesa,
    Plantio $plantio){
        $this->userService = $userService;
        $this->modelInvestimento = $investimento;
        $this->modelDespesa = $despesa;
        $this->modelPlantio = $plantio;
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
            "colunasTabelaResumo"=> ['Total Investido R$', 'Quantidade Total'], /*Array */
            "linhasTabelaHistorico"=> $resultadoRelatorio['linhasTabelaHistorico'], /*Array */
            "linhasTabelaResumo"=> $resultadoRelatorio['linhasTabelaResumo'], /*Array */
            "dataRelatorio"=>$this->dataRelatorio,
            "tituloTabelaResumo"=> "Resumo de Investimentos",
            "tituloTabelaHistorico"=> "Histórico de Investimentos",
            "tituloRelatorio"=> "Relatório de Investimentos",
            "DataEmissaoRelatorio"=> new DateTime()
        ];
    }
    
    public function despesas(array $request){
        if($request['dates']){
            $this->replaceDataRelatorio($request['dates']);
        }
        $resultadoRelatorio = $this->modelDespesa->relatorioDespesas($this->userService->propriedadesUser(), $this->dataRelatorio);
        return [
            "colunasTabelaHistorico"=> ['Despesa','Data','Quantidade','Valor Unitário R$', 'Total Despesa R$'], /*Array */
            "colunasTabelaResumo"=> ['Total Gasto R$', 'Quantidade Total'], /*Array */
            "linhasTabelaHistorico"=> $resultadoRelatorio['linhasTabelaHistorico'], /*Array */
            "linhasTabelaResumo"=> $resultadoRelatorio['linhasTabelaResumo'], /*Array */
            "dataRelatorio"=>$this->dataRelatorio,
            "tituloTabelaResumo"=> "Resumo de Despesas",
            "tituloTabelaHistorico"=> "Histórico de Despesas",
            "tituloRelatorio"=> "Relatório de Despesas",
            "DataEmissaoRelatorio"=> new DateTime()
        ];
    }
    
    public function plantios(array $request){
        if($request['dates']){
            $this->replaceDataRelatorio($request['dates']);
        }
        $resultadoRelatorio = $this->modelPlantio->relatorioPlantios($this->userService->propriedadesUser(), $this->dataRelatorio);
        return [
            "colunasTabelaHistorico"=> ['Produto', 'Quantidade no Plantio', 'Talhão','Data do Plantio ', 'Data da Semeadura'], /*Array */
            "colunasTabelaResumo"=> ['Produto', 'Quantidade Plantada'], /*Array */
            "linhasTabelaHistorico"=> $resultadoRelatorio['linhasTabelaHistorico'], /*Array */
            "linhasTabelaResumo"=> $resultadoRelatorio['linhasTabelaResumo'], /*Array */
            "dataRelatorio"=>$this->dataRelatorio,
            "tituloTabelaResumo"=> "Resumo de Plantios",
            "tituloTabelaHistorico"=> "Histórico de Plantios",
            "tituloRelatorio"=> "Relatório de Plantios",
            "DataEmissaoRelatorio"=> new DateTime()
        ];
    }
}
