<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManejoPlantio extends Model
{
  protected $table = "manejoplantio";
    use SoftDeletes;
  protected $casts = [
    'ID' => 'int',
    'data_hora'=>'datetime:Y-m-d',
  ];

  protected $dates = [
    'data_hora'



  ];

  protected $fillable = [
    'Id'=>'id',
    'Descricao'=>'descricao',
    'Data_hora'=>'data_hora',
    'Horas_utilizadas'=>'horas_utilizadas',
    'Plantio_id'=>'plantio_id',
    'Manejo_id'=>'manejo_id'
  ];

}
