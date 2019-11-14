<?php

namespace App\Models;

use DateTime;
use App\Models\Despesa;
use App\Models\Plantio;
use App\Models\Investimento;
use App\Models\ManejoPlantio;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Model;

class Relatorio extends Model{
    protected $userService;
    protected $dataRelatorio;
    protected $modelInvestimento;
    protected $modelDespesa;
    protected $modelPlantio;
    protected $modelManejoPlantio;
    
    public function __construct(UserService $userService, Investimento $investimento, Despesa $despesa,
    Plantio $plantio, ManejoPlantio $manejoPlantio){
        $this->userService = $userService;
        $this->modelInvestimento = $investimento;
        $this->modelDespesa = $despesa;
        $this->modelPlantio = $plantio;
        $this->modelManejoPlantio = $manejoPlantio;
    }
    

    public function replaceDataRelatorio($datas){
        $datas = explode("até", $datas);
        $dataInicio = trim($datas[0]);
        $dataFim = trim($datas[1]);
        $dataInicio = implode("-",array_reverse(explode("/",$dataInicio)));
        $dataFim = implode("-",array_reverse(explode("/",$dataFim)));
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
    
    public function relatorioManejosPorTalhao(array $request){
        if($request['dates']){
            $this->replaceDataRelatorio($request['dates']);
        }
        $resultadoRelatorio = $this->modelManejoPlantio->relatorioManejosPorTalhao($this->userService->propriedadesUser(), $this->dataRelatorio);
        return [
            "colunasTabelaHistorico"=> ['Manejo', 'Talhão', 'Data do Manejo', 'Data do Plantio', 'Tempo Gasto'], /*Array */
            "colunasTabelaResumo"=> ['Talhão', 'Tempo Total Gasto (H)'], /*Array */
            "linhasTabelaHistorico"=> $resultadoRelatorio['linhasTabelaHistorico'], /*Array */
            "linhasTabelaResumo"=> $resultadoRelatorio['linhasTabelaResumo'], /*Array */
            "dataRelatorio"=>$this->dataRelatorio,
            "tituloTabelaResumo"=> "Resumo de Tempo Total Gasto em cada Talhão",
            "tituloTabelaHistorico"=> "Histórico de Manejos Realizados por Talhão",
            "tituloRelatorio"=> "Histórico de Manejos Realizados por Talhão",
            "DataEmissaoRelatorio"=> new DateTime()
        ];
    }
}
