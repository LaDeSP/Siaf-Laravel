<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DestinoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*Tipo: 1 equivale a destino da venda e 0 equivale a destino da perda*/
        $toInsert = array(
            array('nome'=>"Escola",
                  'tipo'=>1),
  
                  array('nome'=>"Feira",
                  'tipo'=>1),

                  array('nome'=>"Consumo Próprio",
                  'tipo'=>0),

                  array('nome'=>"inutilização",
                  'tipo'=>0),

                  array('nome'=>"Doação",
                  'tipo'=>0),
                  
          );
  
          DB::table('destino')->insert($toInsert);
    }
}
