<?php

/**
* Created by Reliese Model.
* Date: Mon, 26 Aug 2019 14:48:59 -0400.
*/

namespace App\Models;

use Balping\HashSlug\HasHashSlug;
use Illuminate\Support\Facades\DB;
use \Illuminate\Database\Eloquent\SoftDeletes;
use Reliese\Database\Eloquent\Model as Eloquent;

class Venda extends Eloquent{
	
	use SoftDeletes;
	use HasHashSlug;
	protected $table = 'venda';
	
	protected $casts = [
		'quantidade' => 'int',
		'valor_unit' => 'float',
		'destino_id' => 'int',
		'estoque_id' => 'int'
	];
	
	protected $dates = [
		'data'
	];
	
	protected $fillable = [
		'quantidade',
		'valor_unit',
		'data',
		'nota',
		'slug',
		'destino_id',
		'estoque_id'
	];
	
	public function destino(){
		return $this->belongsTo(\App\Models\Destino::class);
	}
	
	public function estoque(){
		return $this->belongsTo(\App\Models\Estoque::class);
	}
	
	public function relatorioVendas($propriedade, $periodo = null){
		if($periodo){
			$tabelaHistorico = Venda::join('estoque', 'venda.estoque_id','=','estoque.id')
			->leftJoin('destino', 'venda.destino_id','=','destino.id')
			->leftJoin('produto', 'estoque.produto_id','=','produto.id')
			->select('produto.nome as 1', 'venda.data as 2', 'destino.nome as 3', 
			'venda.quantidade as 4', 'venda.valor_unit as 5',  
			(DB::raw('sum(venda.quantidade * venda.valor_unit) as \'6\'')))
			->whereBetween('venda.data', [$periodo['dataInicio'], $periodo['dataFim']])
			->where('estoque.propriedade_id', '=',$propriedade->id)
			->whereIn('destino.tipo', [1, 2])
			->groupBy('venda.id')
			->orderBy('2', 'desc')
			->get();
			
			$tabelaResumo = Venda::join('destino', 'venda.destino_id','=','destino.id')
			->join('estoque', 'venda.estoque_id','=','estoque.id')
			->leftJoin('produto', 'estoque.produto_id','=','produto.id')
			->select((DB::raw('produto.nome as \'1\', SUM(venda.quantidade) as \'2\', SUM(venda.quantidade * venda.valor_unit) as \'3\'')))
			->whereBetween('venda.data', [$periodo['dataInicio'], $periodo['dataFim']])
			->where('estoque.propriedade_id', '=',$propriedade->id)
			->whereIn('destino.tipo', [1, 2])
			->groupBy('produto.id')
			->orderBy('3', 'desc')
			->get();
			
		}else{
			$tabelaHistorico = Venda::join('estoque', 'venda.estoque_id','=','estoque.id')
			->leftJoin('destino', 'venda.destino_id','=','destino.id')
			->leftJoin('produto', 'estoque.produto_id','=','produto.id')
			->select('produto.nome as 1', 'venda.data as 2', 'destino.nome as 3', 
			'venda.quantidade as 4', 'venda.valor_unit as 5',  
			(DB::raw('sum(venda.quantidade * venda.valor_unit) as \'6\'')))
			->where('estoque.propriedade_id', '=',$propriedade->id)
			->whereIn('destino.tipo', [1, 2])
			->groupBy('venda.id')
			->orderBy('2', 'desc')
			->get();
			
			$tabelaResumo = Venda::join('destino', 'venda.destino_id','=','destino.id')
			->join('estoque', 'venda.estoque_id','=','estoque.id')
			->leftJoin('produto', 'estoque.produto_id','=','produto.id')
			->select((DB::raw('produto.nome as \'1\', SUM(venda.quantidade) as \'2\', SUM(venda.quantidade * venda.valor_unit) as \'3\'')))
			->where('estoque.propriedade_id', '=',$propriedade->id)
			->whereIn('destino.tipo', [1, 2])
			->groupBy('produto.id')
			->orderBy('3', 'desc')
			->get();
		}
		return [
			'linhasTabelaHistorico'=>$tabelaHistorico,
			'linhasTabelaResumo'=>$tabelaResumo
		];
	}
}
