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
		self::firstOrCreate(['nome'=> $request['nome'] ],['nome'=> $request['nome'], 'descricao'=> $request['descricao'], 'valor_unit'=> $request['valor_unit'], 'quantidade'=> $request['quantidade'], 'data'=> $request['data'], 'propriedade_id'=> $request['propriedade_id'] ]);

	}
}
