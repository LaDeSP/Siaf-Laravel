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
		'Destino'=>'destino',
		'Estoque'=>"estoque_id"
	];

	public function estoque()
	{
		return $this->belongsTo(\App\Models\Estoque::class, 'id');
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
			$venda = self::all();
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
