<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropriedadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $toInsert = array(
          array('users_id'          =>1,
                'nome'              =>'Fazenda do Tomilho',
                'localizacao'       =>'Rural',
                'cidade_id'         =>5129),

          array('users_id'          =>2,
                'nome'              =>'Cidade de Deus',
                'localizacao'       =>'CDD',
                'cidade_id'         =>1)
        );

        DB::table('propriedade')->insert($toInsert);
    }
}
