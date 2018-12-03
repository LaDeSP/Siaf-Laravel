<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDespesaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('despesa', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->longText('descricao')->nullable();
            $table->decimal('valor_unit', 8, 2);
            $table->unsignedInteger('quantidade');
            $table->date('data');
            $table->unsignedInteger('propriedade_id');
            $table->foreign('propriedade_id')->references('id')->on('propriedade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('despesa');
    }
}
