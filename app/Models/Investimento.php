<?php

/**
* Created by Reliese Model.
* Date: Wed, 28 Aug 2019 15:54:39 -0400.
*/

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use \Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\Paginator;
use Balping\HashSlug\HasHashSlug;

class Investimento extends Eloquent{
	use SoftDeletes;
	use HasHashSlug;
	const totalPages = 8;
	
	protected $table = 'investimento';
	
	protected $casts = [
		'valor_unit' => 'float',
		'quantidade' => 'int',
		'propriedade_id' => 'int'
	];
	
	protected $dates = [
		'data'
	];
	
	protected $fillable = [
		'nome',
		'descricao',
		'valor_unit',
		'slug',
		'quantidade',
		'data',
		'propriedade_id'
	];
	
	public function propriedade(){
		return $this->belongsTo(\App\Models\Propriedade::class);
	}
	
	public static function insere($request){
		$investimento = new Investimento();
		$investimento->nome= $request['nome'];
		$investimento->descricao=$request['descricao'];
		$investimento->valor_unit= $request['valor_unit'];
		$investimento->quantidade= $request['quantidade'];
		$investimento->data = $request['data'];
		$investimento->propriedade_id = $request['propriedade_id'];
		$investimento->save();
		if (empty($investimento)) {
			return 405;
		}
		return 200;
	}
	public static function ler($id,$variable){
		if ($id == null) {
			$investimento = self::all()->simplePaginate(self::totalPages);
			dd($investimento);
			if (empty($investimento)) {
				return 405;
			}
			if(sizeof($investimento->items())==0 && $investimento->currentPage()>1 ){
				return false;
			}
			return $investimento;
		}
		if ($variable == null) {
			$investimento = self::find($id);
			if (empty($investimento)) {
				return 405;
			}
			return $investimento;
		} else {
			$investimento = self::where($id,'=',$variable)->simplePaginate(self::totalPages);
			
			if (empty($investimento)) {
				return 405;
			}
			
			if(sizeof($investimento->items())==0 && $investimento->currentPage() > 1 ){
				return false;
			}
			return $investimento;
		}
	}
	
	public static function alterar($request, $id){
		$investimento = self::find($id);
		if (!($investimento->nome == $request['nome'])) {
			$investimento->nome = $request['nome'];
		}
		if (!($investimento->descricao == $request['descricao'])) {
			$investimento->descricao = $request['descricao'];
		}
		if (!($investimento->valor_unit == $request['valor_unit'])) {
			$investimento->valor_unit = $request['valor_unit'];
		}
		if (!($investimento->quantidade == $request['quantidade'])) {
			$investimento->quantidade = $request['quantidade'];
		}
		if (!($investimento->data == $request['data'])) {
			$investimento->data = $request['data'];
		}
		$investimento->save();
		if (empty($investimento)) {
			return 405;
		}
		return 200;
	}
	public static function excluir($id){
		$investimento = Investimento::find($id);
		if (!empty($investimento)) {
			$investimento->delete();
			if (empty($investimento)) {
				return 405;
			}
			return 200;
		}
	}
}
