<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manejo extends Model
{
  protected $table = "manejo";
    use SoftDeletes;




  protected $fillable = [
    'Id'=>'id',
    'Nome'=>'nome',
  ];

}
