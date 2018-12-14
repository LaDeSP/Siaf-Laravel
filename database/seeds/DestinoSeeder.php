<?php

use Illuminate\Database\Seeder;

class DestinoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Tipo 0 = Estoque
        //Tipo 1 = Venda
        $toInsert = array(
            array('nome'               =>"Escola",
                  'tipo'              =>1,
                  ),
  
                  array('nome'               =>"Feira",
                  'tipo'              =>1,
                  ),

                  array('nome'               =>"Consumo Próprio",
                  'tipo'              =>0,
                  ),

                  array('nome'               =>"inutilização",
                  'tipo'              =>0,
                  ),

                  array('nome'               =>"Doação",
                  'tipo'              =>0,
                  ),
                  
          );
  
          DB::table('destino')->insert($toInsert);
    }
}
