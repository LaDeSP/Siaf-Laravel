<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class Perda extends Model
{
  use SoftDeletes;
  protected $table = 'perda';


	protected $casts = [
		'ID' => 'int'
	];

	protected $dates = [
		'Data'
	];

	protected $fillable = [
		'ID'=>'id',
		'Descricao'=>'descricao',
		'Quantidade'=>'quantidade',
		'Data'=>'data',
		'Estoque_id'=>'estoque_id',
    'Destino_id'=>'destino_id'
	];
}
