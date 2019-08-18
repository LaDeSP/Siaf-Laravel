<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 14 Aug 2019 18:57:14 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

class Produto extends Eloquent
{
	protected $table="produto";
    use SoftDeletes;

	protected $casts = [
		'plantavel' => 'bool',
		'status' => 'bool',
		'propriedade_id' => 'int',
		'unidade_id' => 'int'
	];

	protected $fillable = [
		'nome',
		'plantavel',
		'status',
		'propriedade_id',
		'unidade_id'
	];

	public function propriedade()
	{
		return $this->belongsTo(\App\Models\Propriedade::class);
	}

	public function unidade()
	{
		return $this->belongsTo(\App\Models\Unidade::class);
	}

	public function estoques()
	{
		return $this->hasMany(\App\Models\Estoque::class);
	}

	public function plantios()
	{
		return $this->hasMany(\App\Models\Plantio::class);
    }
    
    public static function insere($request){
        try{
            $prod = new Produto();
            $prod->nome = $request->nome;
            $prod->plantavel = ($request->plantavel=='on'? 1:0);
            $prod->propriedade_id = $request->propriedade_id;
            $prod->unidade_id = $request->unidade_id;
            $prod->status = 1;
            $prod->save();
            return 200;
        }catch (\Exception $e){
            return 500;
        }
    }

    public static function atualizar($request, $id){
        try{
            $prod = \App\Models\Produto::find($id);
            $prod->nome = $request['nome'];
            $prod->propriedade_id = $request['propriedade_id'];
            $prod->unidade_id = $request['unidade_id'];
            $prod->plantavel = ($request->plantavel=='on'? 1:0);
            $prod->status = ($request->status=='on'? 1:0);
            $prod->save();
            return 200;
        }catch(\Exception $e){
            return $e;
        }
    }

    public static function ler($request, $id){
        $p = Produto::where('propriedade_id','=',$id)->simplePaginate(3,['*'],"produto");
        if(sizeof($p->items())==0 && $p->currentPage() > 1)
        {
            return false;
        }
        $p->getCollection()->transform(function ($value) {
            $value['unidade_id'] = DB::table('unidade')->where('id', $value['unidade_id'])->where('unidade.deleted_at', '=', null)->value('nome');
            return $value;
        });
        return $p;
    }
}
