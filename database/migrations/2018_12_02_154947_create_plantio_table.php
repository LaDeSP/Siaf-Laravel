<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlantioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plantio', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data_semeadura')->nullable();
            $table->date('data_plantio');
            $table->unsignedInteger('quantidade_pantas')->nullable();
            $table->unsignedInteger('talhao_id');
            $table->foreign('talhao_id')->references('id')->on('talhao');
            $table->unsignedInteger('produto_id');
            $table->foreign('produto_id')->references('id')->on('produto')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('plantio');
    }
}
