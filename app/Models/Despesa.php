<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 28 Aug 2019 15:56:54 -0400.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use \Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\Paginator;

class Despesa extends Eloquent{
	use SoftDeletes;
	protected $table = 'despesa';
	const totalPages = 8;

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

	public function propriedade()
	{
		return $this->belongsTo(\App\Models\Propriedade::class);
	}

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
		   $despesa = self::all()->simplePaginate(self::totalPages);
		   if (empty($despesa)) {
			   return 405;
		   }
	 if(sizeof($despesa->items())==0 && $despesa->currentPage() > 1){
		 return false;
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
		   $despesa = self::where($id,'=',$variable)->simplePaginate(self::totalPages);
		   if (empty($despesa)) {
			   return 405;
		   }
	 if(sizeof($despesa->items())==0 && $despesa->currentPage() > 1){
		 return false;
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
