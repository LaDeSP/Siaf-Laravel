<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Manejo extends Model
{
  protected $table = "manejo";





  protected $fillable = [
    'Id'=>'id',
    'Nome'=>'nome',
  ];

}
