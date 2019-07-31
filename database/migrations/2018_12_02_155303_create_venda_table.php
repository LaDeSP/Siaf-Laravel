<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateVendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venda', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('quantidade');
            $table->decimal('valor_unit', 8, 2);
            $table->date('data');
            $table->string('nota')->nullable();
            $table->unsignedInteger('destino_id');
            $table->foreign('destino_id')->references('id')->on('destino');
            $table->unsignedInteger('estoque_id');
            $table->foreign('estoque_id')->references('id')->on('estoque')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venda');
    }
}
