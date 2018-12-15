<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perda extends Model
{
  use SoftDeletes;

	protected $table = 'Perda';


	protected $casts = [
		'ID' => 'int'
	];

	protected $dates = [
		'Data'
	];

	protected $fillable = [
		'ID',
		'Descricao',
		'Quantidade',
		'Data',
		'Estoque_id'
    'Destino_id'
	];

	public function estoque()
	{
		return $this->belongsTo(\App\Models\Estoque::class, 'id');
	}

	public static function inserir($request)
	{
        $venda = self::firstOrCreate(['ID'=> $request['id'], 'Quantidade' => $request['quantidade'],'Valor' => $request['valor_unit'], 'Data' => $request['data'], 'Nota' => $request['nota'], 'Destino' => $request['destino'], 'Estoque' => $request['estoque_id']]);

        return [$venda, 200];
	}

	public static function ler($id)
	{
		if ($id == null)
		{
			$venda = self::all();
			return $venda;
		}

		$venad = self::find($id);
		return [$venda, 200];
	}

	public static function excluir($id){
		if ($id != null)
		{
			$venda = self::find($id);
		    if (!empty($venda))
		    {
		    	if ($venda->forcedelete())
		    	{
		    		return ["Deletado com sucesso!", 200];
		    	}
			}
		}
		return ["Ocorreu um problema.", 403];
	}
}
