<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Plantio extends Model
{
    protected $table = "plantio";

    protected $casts = [
  		'ID' => 'int',
      'data_semeadura'=>'date:d-m-Y',
      'data_plantio'=>'date:d-m-Y'
  	];

    protected $dates = [
      'data_semeadura',
      'data_plantio'


    ];

    protected $fillable = [
      'Id'=>'id',
      'Data_semeadura'=>'data_semeadura',
      'Data_plantio'=>'data_plantio',
      'Quantidade_pantas'=>'quantidade_pantas',
      'Talhao'=>'talhao_id',
      'Produto'=>'produto_id'
  	];

    public static function get($id=null)
    {
      if ($id == null)
      {
        $plantio = self::all();
        return $plantio;
      }

      $plantio = self::find($id);
      return [$plantio, 200];
    }

  /*  public static function create($request)
    {
      return $request;
      $venda = DB::table("plantio")->insert([ 'Data_semeadura' => $request['data_semeadura'],'Data_plantio' => $request['data_plantio'], 'Quantidade_pantas' => $request['quantidade_pantas'], 'Talhao' => $request['talhao'], 'Produto' => $request['produto']]);
      return [$venda, 200];
    }*/

}
