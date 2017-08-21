<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnderecosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('logradouro',150);
            $table->string('numero',5);
            $table->string('complemento',20);
            $table->unsignedInteger('bairro');
            $table->string('cidade', 50);
            $table->enum('estado',array( 'AC', 'AL', 'AM', 'AP', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RO', 'RS', 'RR', 'SC', 'SE', 'SP', 'TO' ));
            $table->char('cep');
            $table->unsignedInteger('atualizado_por');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('bairro')
                ->references('id')
                ->on('bairros_sanca')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->foreign('atualizado_por')
                ->references('id')
                ->on('pessoas')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enderecos');
    }
}
