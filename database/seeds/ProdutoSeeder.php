<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $toInsert = array(
            array('nome'              => 'tomate',
                  'status'            => 1,
                  'propriedade_id'    => 1,
                  'unidade_id'        => 1),

            array('nome'            => 'cenoura',
                'status'            => 1,
                'propriedade_id'    => 1,
                'unidade_id'        => 3),

            array('nome'            => 'milho',
                'status'            => 1,
                'propriedade_id'    => 2,
                'unidade_id'        => 4),
        );

        DB::table('produto')->insert($toInsert);
    }
}
