<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 26 Aug 2019 14:48:59 -0400.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use \Illuminate\Database\Eloquent\SoftDeletes;

class Venda extends Eloquent{
	
	use SoftDeletes;
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

	public static function mudou(){
		static  $change=0;
		if($change){
			$change=0;
			return 1;
		}
		return $change;

	}

	public static function destinos(){
		$destinos = DB::table('destino')
		->select('destino.id', 'nome AS destino')
		->where('destino.deleted_at','=',null)
		->where('destino.tipo','=',1)
		->get();
		return $destinos;
	}

	public static function vendas($propriedade, $id)
	{
		if($id)
		{
			$venda = DB::table('venda')
			->join('estoque', 'estoque.id', '=', 'estoque_id')
			->join('produto', 'produto.id', '=', 'estoque.produto_id')
			->join('unidade', 'unidade.id', '=', 'produto.unidade_id')
			->join('propriedade', 'propriedade.id', '=', 'estoque.propriedade_id')
			->join('destino', 'destino.id', '=', 'destino_id')
			->select('unidade.nome AS unidade','venda.id','produto.nome AS produto','venda.quantidade', 'venda.valor_unit', 'venda.data AS datavenda','venda.nota',
			'destino.nome', 'destino.id','estoque.data','venda.estoque_id','venda.destino_id')
			->where('estoque.propriedade_id', '=', $propriedade->id)
			->where('venda.id', '=', $id)
			->where('venda.deleted_at','=',null)
			->first();
			return $venda;
		}
		$allVenda = DB::table('venda')
		->join('estoque', 'estoque.id', '=', 'estoque_id')
		->join('produto', 'produto.id', '=', 'estoque.produto_id')
		->join('unidade', 'unidade.id', '=', 'produto.unidade_id')
		->join('propriedade', 'propriedade.id', '=', 'estoque.propriedade_id')
		->join('destino', 'destino.id', '=', 'destino_id')
		->select((DB::raw('(venda.valor_unit*venda.quantidade) as total')),'unidade.nome AS unidade', 'venda.id','produto.nome AS produto','venda.quantidade', 'venda.valor_unit', 'venda.data','venda.nota',
		'destino.nome', 'venda.estoque_id', 'venda.destino_id')
		->orderByDesc('venda.data')
		->where('estoque.propriedade_id', '=', $propriedade->id)
		->where('venda.deleted_at','=',null)
		->simplePaginate(self::totalPages);

		if(sizeof($allVenda->items())==0 && $allVenda->currentPage() > 1){
				return false;

		}
		return $allVenda;
	}

	public static function inserir($request)
	{
		$venda = DB::table("venda")->insert([ 'Quantidade' => $request['quantidade'],'Valor' => $request['valor_unit'], 'Data' => $request['data'], 'Nota' => $request['nota'], 'Destino' => $request['destino_id'], 'Estoque' => $request['estoque_id']]);

		return [$venda, 200];
	}

	public static function ler($id)
	{
		$venda = null;
		if ($id == null)
		{
			$venda = self::all()->simplePaginate(self::totalPages);
			return $venda;
		}

		$venda = self::find($id);
		return [$venda, 200];
	}

	public static function excluir($id){
		if ($id != null)
		{
			$venda = self::find($id);
			if (!empty($venda))
			{
				if ($venda->delete())
				{
					return ["Deletado com sucesso!", 200];
				}
			}
		}
		return ["Ocorreu um problema.", 403];
	}
}
