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
          array('users_id'          =>'47110931099',
                'nome'              =>'Fazenda do Tomilho',
                'localizacao'       =>'Rural',
                'cidade_id'         =>1),

          array('users_id'          =>'47110931099',
                'nome'              =>'Outra Fazenda do Tomilho',
                'localizacao'       =>'Judas perdeu as botas',
                'cidade_id'         =>1),

          array('users_id'          =>'47110931099',
                'nome'              =>'Mais uma do Tomilho',
                'localizacao'       =>'Pode excluir essa',
                'cidade_id'         =>1),

          array('users_id'          =>'83552301089',
                'nome'              =>'Cidade de Deus',
                'localizacao'       =>'CDD',
                'cidade_id'         =>1)
        );

        DB::table('propriedade')->insert($toInsert);
    }
}
