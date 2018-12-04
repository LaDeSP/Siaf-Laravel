<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalhaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talhao', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('area');
            $table->boolean('status');
            $table->string('nome');
            $table->unsignedInteger('propriedade_id');
            $table->foreign('propriedade_id')->references('id')->on('propriedade')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('talhao');
    }
}
