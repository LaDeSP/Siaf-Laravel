<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerdaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perda', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('descricao')->nullable();
            $table->unsignedInteger('quantidade');
            $table->date('data');
            $table->unsignedInteger('estoque_id')->nullable();
            $table->unsignedInteger('plantio_id')->nullable();
            $table->foreign('estoque_id')->references('id')->on('estoque')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('plantio_id')->references('id')->on('plantio')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('destino_id');
            $table->foreign('destino_id')->references('id')->on('destino');
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
        Schema::dropIfExists('perda');
    }
}
