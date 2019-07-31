<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $toInsert = array(
          array('cpf'               =>"47110931099",
                'name'              =>'Tomilho fazendeiro',
                'email'             =>'tomilho@gmail.com',
                'telefone'          =>'67999999999',
                'password'          =>bcrypt('tom123456')),

          array('cpf'               =>"83552301089",
                'name'              =>'Zé pequeno',
                'email'             =>'dadinho@gmail.com',
                'telefone'          =>'67988999999',
                'password'          =>bcrypt('littleze')),
        );

        DB::table('users')->insert($toInsert);
    }
}