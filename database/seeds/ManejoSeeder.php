<?php

use Illuminate\Database\Seeder;

class ManejoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $toInsert = array(
          array('nome' => "Capina"),
          array('nome' => "Desbaste"),
          array('nome' => "Rega"),
          array('nome' => "Colheita"),
          array('nome' => "Controle Pragas"),
          array('nome' => "Adubação"),
          array('nome' => "Aração")
        );
        DB::table('manejo')->insert($toInsert);
    }
}
