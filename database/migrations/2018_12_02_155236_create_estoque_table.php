<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateEstoqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estoque', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('quantidade');
            $table->unsignedInteger('produto_id');
            $table->date('data');
            $table->foreign('produto_id')->references('id')->on('produto');
            $table->unsignedInteger('propriedade_id');
            $table->foreign('propriedade_id')->references('id')->on('propriedade')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('manejoplantio_id')->nullable();
            $table->foreign('manejoplantio_id')->references('id')->on('manejoplantio');
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
        Schema::dropIfExists('estoque');
    }
}
