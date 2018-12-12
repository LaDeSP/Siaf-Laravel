<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Investimento extends Model
{
    protected $table = 'investimento';

	protected $fillable = [
		'nome',
		'descricao',
		'valor_unit',
		'quantidade',
		'data',
		'propriedade_id'
	];

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
			$investimento = self::all();
			if (empty($investimento)) {
				return 405;
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
			$investimento = self::all()->where($id,'=',$variable);
			if (empty($investimento)) {
				return 405;
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
