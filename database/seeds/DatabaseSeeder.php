<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ManejoSeeder::class,
            EstadoSeeder::class,
            CidadeSeeder::class,
            UserSeeder::class,
            PropriedadeSeeder::class,
            UnidadeSeeder::class,
            TalhaoSeeder::class,
            ProdutoSeeder::class

        ]);
    }
}
