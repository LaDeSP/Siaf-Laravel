<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManejoplantioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manejoplantio', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('descricao')->nullable();
            $table->dateTime('data_hora');
            $table->unsignedInteger('horas_utilizadas');
            $table->unsignedInteger('plantio_id');
            $table->foreign('plantio_id')->references('id')->on('plantio');
            $table->unsignedInteger('manejo_id');
            $table->foreign('manejo_id')->references('id')->on('manejo');
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
        Schema::dropIfExists('manejoplantio');
    }
}
