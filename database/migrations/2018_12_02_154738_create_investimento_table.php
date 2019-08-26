<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvestimentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investimento', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->longText('descricao')->nullable();
            $table->decimal('valor_unit', 8, 2);
            $table->string('slug')->nullable();
            $table->unsignedInteger('quantidade');
            $table->date('data');
            $table->unsignedInteger('propriedade_id');
            $table->foreign('propriedade_id')->references('id')->on('propriedade')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('investimento');
    }
}
