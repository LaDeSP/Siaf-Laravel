<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $toInsert = array(
            array('nome' => "KG"),
            array('nome' => "LT"),
            array('nome' => "UN"),
            array('nome' => "DZ")
        );

        DB::table('unidade')->insert($toInsert);
    }
}
