<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estado')->
        insert( array(
          array('nome'=>'Tocantins'),
          array('nome'=>'São Paulo'),
          array('nome'=>'Sergipe'),
          array('nome'=>'Santa Catarina'),
          array('nome'=>'Roraima'),
          array('nome'=>'Rondônia'),
          array('nome'=>'Rio Grande do Sul'),
          array('nome'=>'Rio Grande do Norte'),
          array('nome'=>'Rio de Janeiro'),
          array('nome'=>'Piauí'),
          array('nome'=>'Pernambuco'),
          array('nome'=>'Pará'),
          array('nome'=>'Paraíba'),
          array('nome'=>'Paraná'),
          array('nome'=>'Minas Gerais'),
          array('nome'=>'Mato Grosso do Sul'),
          array('nome'=>'Mato Grosso'),
          array('nome'=>'Maranhão'),
          array('nome'=>'Goiás'),
          array('nome'=>'Espírito Santo'),
          array('nome'=>'Distrito Federal'),
          array('nome'=>'Ceará'),
          array('nome'=>'Bahia'),
          array('nome'=>'Amazonas'),
          array('nome'=>'Amapá'),
          array('nome'=>'Alagoas'),
          array('nome'=>'Acre')
        ));
    }
}
