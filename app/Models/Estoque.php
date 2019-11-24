<?php

/**
* Created by Reliese Model.
* Date: Mon, 26 Aug 2019 15:12:45 -0400.
*/

namespace App\Models;

use DateTime;
use App\Models\Perda;
use App\Models\Venda;
use App\Services\EstoqueService;
use Balping\HashSlug\HasHashSlug;
use Illuminate\Support\Facades\DB;
use \Illuminate\Database\Eloquent\SoftDeletes;
use Reliese\Database\Eloquent\Model as Eloquent;

class Estoque extends Eloquent{
	use SoftDeletes;
	use HasHashSlug;
	protected $table = 'estoque';
	
	protected $casts = [
		'quantidade' => 'int',
		'produto_id' => 'int',
		'propriedade_id' => 'int',
		'manejoplantio_id' => 'int'
	];
	
	protected $dates = [
		'data'
	];
	
	protected $fillable = [
		'quantidade',
		'produto_id',
		'data',
		'slug',
		'propriedade_id',
		'manejoplantio_id'
	];
	
	public function manejoplantio(){
		return $this->belongsTo(\App\Models\ManejoPlantio::class);
	}
	
	public function produto(){
		return $this->belongsTo(\App\Models\Produto::class);
	}
	
	public function propriedade(){
		return $this->belongsTo(\App\Models\Propriedade::class);
	}
	
	public function perdas(){
		return $this->hasMany(\App\Models\Perda::class);
	}
	
	public function vendas(){
		return $this->hasMany(\App\Models\Venda::class);
	}
	
	public function relatorioEstoquesPorPropriedade($propriedade, $periodo = null){
		if($periodo){
			$tabelaHistorico = Estoque::leftJoin('manejoplantio', 'estoque.manejoplantio_id','=','manejoplantio.id')
			->leftJoin('plantio', 'manejoplantio.plantio_id','=','plantio.id')
			->leftJoin('talhao', 'plantio.talhao_id','=','talhao.id')
			->join('produto', 'estoque.produto_id','=','produto.id')
			->join('propriedade', 'estoque.propriedade_id','=','propriedade.id')
			->select('estoque.id','propriedade.nome as 1', 'produto.nome as 2', 'plantio.data_plantio as 3',
			'talhao.nome as 4','estoque.data as 5','estoque.quantidade as 6', 'estoque.quantidade as quantidade')
			->whereBetween('estoque.data', [$periodo['dataInicio'], $periodo['dataFim']])
			->where('estoque.propriedade_id', '=', $propriedade->id)
			->groupBy('estoque.id')
			->get()->values();
			
			foreach ($tabelaHistorico as $key => $estoque) {
				$estoque['7'] = EstoqueService::quantidadeDisponivelDeProdutoEstoque($estoque);
				$estoque->__unset('quantidade');
				$estoque->__unset('id');
			}
			
			$tabelaResumo = Estoque::leftJoin('manejoplantio', 'estoque.manejoplantio_id','=','manejoplantio.id')
			->leftJoin('plantio', 'manejoplantio.plantio_id','=','plantio.id')
			->leftJoin('talhao', 'plantio.talhao_id','=','talhao.id')
			->join('produto', 'estoque.produto_id','=','produto.id')
			->join('propriedade', 'estoque.propriedade_id','=','propriedade.id')
			->select('propriedade.nome as 1','produto.nome as 2',
			DB::raw('SUM(estoque.quantidade) as \'3\''),
			DB::raw('SUM(estoque.quantidade) as \'4\''))
			->whereBetween('estoque.data', [$periodo['dataInicio'], $periodo['dataFim']])
			->where('estoque.propriedade_id', '=', $propriedade->id)
			->groupBy('produto.id')
			->get();
			
			foreach ($tabelaResumo as $estoque) {
				$atual = (Venda::join('estoque','venda.estoque_id','=','estoque.id')
				->where('estoque.produto_id','=',$estoque->produto_id)
				->where('estoque.propriedade_id','=',$propriedade->id)
				->sum('venda.quantidade'))+(Perda::join('estoque','perda.estoque_id','=','estoque.id')
				->whereBetween('estoque.data', [$periodo['dataInicio'], $periodo['dataFim']])
				->where('estoque.produto_id','=',$estoque->produto_id)->where('estoque.propriedade_id','=',$propriedade->id)
				->sum('perda.quantidade'));
				$estoque['4'] = $estoque['4'] - $atual;
				$estoque->__unset('produto_id');
			}
			
		}else{
			$tabelaHistorico = Estoque::leftJoin('manejoplantio', 'estoque.manejoplantio_id','=','manejoplantio.id')
			->leftJoin('plantio', 'manejoplantio.plantio_id','=','plantio.id')
			->leftJoin('talhao', 'plantio.talhao_id','=','talhao.id')
			->join('produto', 'estoque.produto_id','=','produto.id')
			->join('propriedade', 'estoque.propriedade_id','=','propriedade.id')
			->select('estoque.id','propriedade.nome as 1', 'produto.nome as 2', 'plantio.data_plantio as 3',
			'talhao.nome as 4','estoque.data as 5','estoque.quantidade as 6', 'estoque.quantidade as quantidade')
			->where('estoque.propriedade_id', '=', $propriedade->id)
			->groupBy('estoque.id')
			->get()->values();
			
			foreach ($tabelaHistorico as $key => $estoque) {
				$estoque['7'] = EstoqueService::quantidadeDisponivelDeProdutoEstoque($estoque);
				$estoque->__unset('quantidade');
				$estoque->__unset('id');
			}
			
			$tabelaResumo = Estoque::leftJoin('manejoplantio', 'estoque.manejoplantio_id','=','manejoplantio.id')
			->leftJoin('plantio', 'manejoplantio.plantio_id','=','plantio.id')
			->leftJoin('talhao', 'plantio.talhao_id','=','talhao.id')
			->join('produto', 'estoque.produto_id','=','produto.id')
			->join('propriedade', 'estoque.propriedade_id','=','propriedade.id')
			->select('produto.id as produto_id','propriedade.nome as 1','produto.nome as 2',
			DB::raw('SUM(estoque.quantidade) as \'3\''),
			DB::raw('SUM(estoque.quantidade) as \'4\''))
			->where('estoque.propriedade_id', '=', $propriedade->id)
			->groupBy('produto.id')
			->get();
			
			foreach ($tabelaResumo as $estoque) {
				$atual = (Venda::join('estoque','venda.estoque_id','=','estoque.id')
				->where('estoque.produto_id','=',$estoque->produto_id)
				->where('estoque.propriedade_id','=',$propriedade->id)
				->sum('venda.quantidade'))+(Perda::join('estoque','perda.estoque_id','=','estoque.id')
				->where('estoque.produto_id','=',$estoque->produto_id)->where('estoque.propriedade_id','=',$propriedade->id)
				->sum('perda.quantidade'));
				$estoque['4'] = $estoque['4'] - $atual;
				$estoque->__unset('produto_id');
			}
		}
		return [
			'linhasTabelaHistorico'=>$tabelaHistorico,
			'linhasTabelaResumo'=>$tabelaResumo
		];
	}
	
	public function estoquesUltimosQuinzeDias($propriedade){
		$dataAtual = new \DateTime();
		$datafim = $dataAtual->format('Y-m-d H:i:s');
		$data=date('Y-m-d',strtotime("-15 day", strtotime($datafim)));
		$totalG=Estoque::leftJoin('manejoplantio', 'estoque.manejoplantio_id','=','manejoplantio.id')
		->leftJoin('plantio', 'manejoplantio.plantio_id','=','plantio.id')
		->leftJoin('talhao', 'plantio.talhao_id','=','talhao.id')
		->join('produto', 'estoque.produto_id','=','produto.id')
		->join('propriedade', 'estoque.propriedade_id','=','propriedade.id')
		->select('estoque.produto_id','propriedade.nome as propriedade','produto.nome as produto',DB::raw('SUM(estoque.quantidade) as total'),DB::raw('SUM(estoque.quantidade) as total_atual'))
		->whereBetween('estoque.data', [$data, $datafim])
		->where('estoque.propriedade_id', '=', $propriedade->id)
		->groupBy('produto.id')->orderBy('total_atual', 'desc')
		->limit(3)
		->get();
		foreach ($totalG as $key => $value) {
			$pv = (Venda::join('estoque','venda.estoque_id','=','estoque.id')
			->where('estoque.produto_id','=',$value->produto_id)
			->where('estoque.propriedade_id','=',$propriedade->id)
			->whereBetween('estoque.data', [$data, $datafim])
			->sum('venda.quantidade'))
			+
			(Perda::join('estoque','perda.estoque_id','=','estoque.id')
			->where('estoque.produto_id','=',$value->produto_id)
			->where('estoque.propriedade_id','=',$propriedade->id)
			->whereBetween('estoque.data', [$data, $datafim])
			->sum('perda.quantidade'));
			$value->total_atual= $value->total_atual - $pv;
		}
		return $totalG;
	}
}
