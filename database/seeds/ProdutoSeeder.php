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
            'tipo'            => 'c_temporaria',
            'unidade_id'        => 1,
            'status'         => 1),
            
            array('nome'            => 'cenoura',
            'propriedade_id'    => 1,
            'tipo'            => 'c_temporaria',
            'unidade_id'        => 3,
            'status'         => 1),
            
            array('nome'            => 'laranja',
            'propriedade_id'    => 1,
            'tipo'            => 'c_permanente',
            'unidade_id'        => 3,
            'status'         => 1),  
            
            array('nome'            => 'bolacha',
            'propriedade_id'    => 1,
            'tipo'            => 'processado',
            'unidade_id'        => 3,
            'status'         => 1),
            
            array('nome'            => 'queijo',
            'propriedade_id'    => 2,
            'tipo'            => 1,
            'unidade_id'        => 4,
            'status'         => 1),
            
            array('nome'            => 'milho',
            'propriedade_id'    => 2,
            'tipo'            => 'c_temporaria',
            'unidade_id'        => 4,
            'status'         => 1),
        );
        
        DB::table('produto')->insert($toInsert);
    }
}
