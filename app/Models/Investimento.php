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
		return self::firstOrCreate(['nome'=> $request['nome'] ],['nome'=> $request['nome'], 'descricao'=> $request['descricao'], 'valor_unit'=> $request['valor_unit'], 'quantidade'=> $request['quantidade'], 'data'=> $request['data'], 'propriedade_id'=> $request['propriedade_id'] ]);
	}
	public static function ler($id,$variable){
		if ($id == null) {
			return self::all();
		} 
		if ($variable == null) {
			$investimento = self::find($id);
			return $investimento;
		} else {
			$investimento = self::all()->where($id,'=',$variable);
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
		return 200;
	}
	public static function excluir($id){
		$investimento = Investimento::find($id);
		if (!empty($investimento)) {
			$investimento->delete();
			return 200;
		}
	}
}
