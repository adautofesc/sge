<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDividaAtivaDadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('divida_ativa_dados', function (Blueprint $table) {
            $table->id();
            $table->bigIncrements('divida');
            $table->enum('dado',['boleto','amortizacao','boletos_renegociacao']);
            $table->string('conteudo',300);
            $table->foreign('divida')->
                references('id')->
                on('divida_ativa')->
                onDelete('cascade')->
                onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('divida_ativa_dados');
    }
}
