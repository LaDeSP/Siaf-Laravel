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
        DB::table('propriedade')->
        insert([
            'users_id'          =>'47110931099',
            'nome'              =>'Fazenda do Tomilho',
            'localizacao'       =>'Rural',
            'cidade_id'         =>1
        ]);
    }
}
