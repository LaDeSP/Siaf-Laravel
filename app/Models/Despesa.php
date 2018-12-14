<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Despesa extends Model
{
   	protected $table = 'despesa';
    use SoftDeletes;
	protected $fillable = [
		'nome',
		'descricao',
		'valor_unit',
		'quantidade',
		'data',
		'propriedade_id'
	];

	public static function inserir($request){
		 $despesa = new Despesa();
		 $despesa->nome= $request['nome'];
		 $despesa->descricao=$request['descricao'];
		 $despesa->valor_unit= $request['valor_unit'];
		 $despesa->quantidade= $request['quantidade'];
		 $despesa->data = $request['data'];
		 $despesa->propriedade_id = $request['propriedade_id'];
		 $despesa->save();
		if (empty($despesa)) {
			return 405;
		}
		return 200;
	}
	public static function ler($id,$variable){
		if ($id == null) {
			$despesa = self::all();
			if (empty($despesa)) {
				return 405;
			}
			return $despesa;
		} 
		if ($variable == null) {
			$despesa = self::find($id);
			if (empty($despesa)) {
				return 405;
			}
			return $despesa;
		} else {
			$despesa = self::all()->where($id,'=',$variable);
			if (empty($despesa)) {
				return 405;
			}
			return $despesa;
		}
	}
	public static function alterar($request,$id){
		$despesa = self::find($id);
		if (!($despesa->nome == $request['nome'])) {
			$despesa->nome = $request['nome'];
		}
		if (!($despesa->descricao == $request['descricao'])) {
			$despesa->descricao = $request['descricao'];
		}
		if (!($despesa->valor_unit == $request['valor_unit'])) {
			$despesa->valor_unit = $request['valor_unit'];
		}
		if (!($despesa->quantidade == $request['quantidade'])) {
			$despesa->quantidade = $request['quantidade'];
		}
		if (!($despesa->data == $request['data'])) {
			$despesa->data = $request['data'];
		}
		$despesa->save();
		if (empty($despesa)) {
			return 405;
		}
		return 200;
	}
	public static function excluir($id){
		$despesa = Despesa::find($id);
		if (!empty($despesa)) {
			$despesa->delete();
			return 200;
		}
	}
}
