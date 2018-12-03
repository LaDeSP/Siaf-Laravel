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
        DB::table('users')->
            insert([
                'cpf'               =>"47110931099",
                'name'              =>'Tomilho fazendeiro',
                'email'             =>'tomilho@gmail.com',
                'telefone'          =>'67999999999',
                'password'          =>bcrypt('tom123456')
            ]);
    }
}