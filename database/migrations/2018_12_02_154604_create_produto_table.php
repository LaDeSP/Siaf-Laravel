<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produto', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            /*Tipo do produto: processado, cultura permanente e cultura temporaria */
            $table->enum('tipo', ['processado', 'c_temporaria', 'c_permanente']);	
            $table->boolean('status');
            $table->unsignedInteger('propriedade_id');
            $table->foreign('propriedade_id')->references('id')->on('propriedade')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('unidade_id');
            $table->foreign('unidade_id')->references('id')->on('unidade');
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
        Schema::dropIfExists('produto');
    }
}
