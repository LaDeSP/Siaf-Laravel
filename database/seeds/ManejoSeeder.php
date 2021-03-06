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
          array('nome' => "Controle de pragas"),
          array('nome' => "Adubação"),
          array('nome' => "Aração"),
          array('nome' => "Perda")
        );
        DB::table('manejo')->insert($toInsert);
    }
}
