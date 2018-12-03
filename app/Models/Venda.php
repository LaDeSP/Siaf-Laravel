<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    
    use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'venda';
	protected $primaryKey = 'ID';
	public $incrementing = false;

	protected $casts = [
		'ID' => 'int'
	];

	protected $dates = [
		'Data'
	];

	protected $fillable = [
		'ID',
		'Quantidade',
		'Valor',
		'Data',
		'Nota',
		'Destino',
		'Estoque'
	];

	public function estoque()
	{
		return $this->belongsTo(\App\Models\Estoque::class, 'id');
	} 

	public static function inserir($request)
	{
        $venda = self::firstOrCreate(['ID'=> $request['id'], 'Quantidade' => $request['quantidade'],'Valor' => $request['valor_unit'], 'Data' => $request['data'], 'Nota' => $request['nota'], 'Destino' => $request['destino_id'], 'Estoque' => $request['estoque_id']]);

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
