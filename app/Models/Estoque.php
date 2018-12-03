<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{

    use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'estoque';
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
		'Data',
		'Plantio',
		'Quantidade'
	];


	public function produto()
	{
		return $this->belongsTo(\App\Models\Produto::class, 'id');
	}

	public function plantio()
	{
		return $this->belongsTo(\App\Models\Plantio::class, 'id');
	}

	public function propriedade()
	{
		return $this->belongsTo(\App\Models\Propriedade::class, 'id');
	} 

	public static function inserir($request)
	{
        $estoque = self::firstOrCreate(['ID'=> $request['id'], 'Quantidade' => $request['quantidade'],'Produto' => $request['produto_id'], 'Data' => $request['data'], 'Propriedade' => $request['propriedade_id'], 'Plantio' => $request['plantio_id']]);

        return [$estoque, 200];
	}

	public static function ler($id)
	{
		if ($id == null) 
		{
			$estoque = self::all();
			return $estoque;
		}

		$estoque = self::find($id);
		return [$estoque, 200];
	}

	public static function excluir($id){
		if ($id != null) 
		{
			$estoque = self::find($id);
		    if (!empty($estoque)) 
		    {
		    	if ($estoque->forcedelete()) 
		    	{
		    		return ["Deletado com sucesso!", 200];
		    	}
			}
		}
		return ["Ocorreu um problema, lamentamos o inconveniente.", 403];
	}

}
