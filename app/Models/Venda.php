<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Venda extends Model
{
	
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'venda';
	protected $primaryKey = 'id';
	public $incrementing = false;
	use SoftDeletes;
	private const totalPages = 5;
	protected $casts = [
		'ID' => 'int'
	];
	
	protected $dates = [
		'Data'
	];
	
	protected $fillable = [
		'ID'=>"id",
		'Quantidade'=>'quantidade',
		'Valor'=>"valor_unit",
		'Data'=>'data',
		'Nota'=>"nota",
		'Destino'=>'destino_id',
		'Estoque'=>"estoque_id"
	];
	
	public static function destino()
	{
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
			->join('propriedade', 'propriedade.id', '=', 'estoque_id')
			->join('destino', 'destino.id', '=', 'destino_id')
			->select('unidade.nome AS unidade','venda.id','produto.nome AS produto','venda.quantidade', 'venda.valor_unit', 'venda.data','venda.nota',
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
		->join('propriedade', 'propriedade.id', '=', 'estoque_id')
		->join('destino', 'destino.id', '=', 'destino_id')
		->select((DB::raw('(venda.valor_unit*venda.quantidade) as total')),'unidade.nome AS unidade', 'venda.id','produto.nome AS produto','venda.quantidade', 'venda.valor_unit', 'venda.data','venda.nota',
		'destino.nome', 'venda.estoque_id', 'venda.destino_id')
		->where('estoque.propriedade_id', '=', $propriedade->id)
		->where('venda.deleted_at','=',null)
		->paginate(self::totalPages);
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
			$venda = self::all()->paginate(self::totalPages);
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
