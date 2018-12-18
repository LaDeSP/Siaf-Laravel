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
                  'propriedade_id'    => 1,
                  'status'            => 1,
                  'unidade_id'        => 1,
                  'plantavel'         => 1),

            array('nome'            => 'cenoura',
                'propriedade_id'    => 1,
                'status'            => 1,
                'unidade_id'        => 3,
                'plantavel'         => 1),

            array('nome'            => 'queijo',
                'propriedade_id'    => 2,
                'status'            => 1,
                'unidade_id'        => 4,
                'plantavel'         => 0),

            array('nome'            => 'milho',
                'propriedade_id'    => 2,
                'unidade_id'        => 4,
                'status'            => 1,
                'plantavel'         => 1),
        );

        DB::table('produto')->insert($toInsert);
    }
}
