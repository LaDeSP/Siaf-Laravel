<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropriedadeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propriedade', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('users_id');
            $table->string('nome');
            $table->string('localizacao');
            $table->string('slug');

            $table->unsignedInteger('cidade_id');
            $table->foreign('cidade_id')->references('id')->on('cidade');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('propriedade');
    }
}
