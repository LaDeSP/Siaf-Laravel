<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    protected $table = "cidade";

  static function cordenadas($id)
      {
          $cidades=self::all()->where('id','=',$id);
          return array_first($cidades);
      }
}
