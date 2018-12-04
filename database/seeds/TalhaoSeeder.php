<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TalhaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $toInsert = array(
          array('area'           =>25,
                'status'            => 1,
                'nome'           =>'Fazenda do Tomilho',
                'propriedade_id' =>1),

          array('area'           =>100,
                'status'            => 1,
                'nome'           =>'Fazenda do Tomilho',
                'propriedade_id' =>1),

          array('area'           =>50,
                'status'            => 1,
                'nome'           =>'Talhãozão de deus',
                'propriedade_id' =>2),

        );
        DB::table('talhao')->insert($toInsert);
    }
}
