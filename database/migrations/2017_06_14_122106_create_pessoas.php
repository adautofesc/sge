<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePessoas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        

        Schema::create('pessoas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->char('genero',1);
            $table->date('nascimento');
            $table->unsignedInteger('por');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('por')->
                references('id')->
                on('pessoas')->
                onDelete('restrict')->
                onUpdate('restrict');

        });
        Schema::create('pessoas_dados_gerais', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pessoa');
            $table->unsignedInteger('dado');
            $table->string('valor',150);
            $table->softDeletes();
            $table->timestamps('created');

            //-criação das chaves
            $table->foreign('pessoa')->
                references('id')->
                on('pessoas')->
                onDelete('restrict')->
                onUpdate('restrict');
            $table->foreign('dado')->
                references('id')->
                on('tipos_dados')->
                onDelete('restrict')->
                onUpdate('restrict');
        });
        Schema::create('pessoas_dados_contato', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pessoa');
            $table->unsignedInteger('dado');
            $table->string('valor',150);
            $table->softDeletes();
            $table->timestamps('created');
            //-criação das chaves
            $table->foreign('pessoa')
                ->references('id')
                ->on('pessoas')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('dado')->
                references('id')->
                on('tipos_dados')->
                onDelete('restrict')->
                onUpdate('restrict');
        });
        Schema::create('pessoas_dados_academicos', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->unsignedInteger('pessoa');
            $table->unsignedInteger('dado');
            $table->string('valor',150);
            $table->softDeletes();
            $table->timestamps('created');
            //-criação das chaves
            $table->foreign('pessoa')
                ->references('id')
                ->on('pessoas')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('dado')->
                references('id')->
                on('tipos_dados')->
                onDelete('restrict')->
                onUpdate('restrict');
        });
        Schema::create('pessoas_dados_administrativos', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->unsignedInteger('pessoa');
            $table->unsignedInteger('dado');
            $table->softDeletes();
            $table->string('valor',150);
            $table->timestamps('created');
            //-criação das chaves
            $table->foreign('pessoa')
                ->references('id')
                ->on('pessoas')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('dado')->
                references('id')->
                on('tipos_dados')->
                onDelete('restrict')->
                onUpdate('restrict');
        });
        Schema::create('pessoas_dados_clinicos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pessoa');
            $table->unsignedInteger('dado');
            $table->string('valor',150);
            $table->softDeletes();
            $table->timestamps('created');
            //-criação das chaves
            $table->foreign('pessoa')
                ->references('id')
                ->on('pessoas')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('dado')->
                references('id')->
                on('tipos_dados')->
                onDelete('restrict')->
                onUpdate('restrict');
        });
        Schema::create('pessoas_dados_financeiros', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pessoa');
            $table->unsignedInteger('dado');
            $table->string('valor',150);
            $table->softDeletes();
            $table->timestamps('created');
            //-criação das chaves
            $table->foreign('pessoa')
                ->references('id')
                ->on('pessoas')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->foreign('dado')->
                references('id')->
                on('tipos_dados')->
                onDelete('restrict')->
                onUpdate('restrict');
        });
        Schema::create('pessoas_dados_acesso', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pessoa');
            $table->string('usuario',15)->unique();
            $table->string('senha');
            $table->date('validade');
            $table->char('status',1);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();

            //-criação das chaves
            $table->foreign('pessoa')
                ->references('id')
                ->on('pessoas')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });

        Schema::create('pessoas_controle_acessos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pessoa');
            $table->unsignedInteger('recurso');
            $table->softDeletes();

            //-criação das chaves
            $table->foreign('pessoa')
                ->references('id')
                ->on('pessoas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('recurso')
                ->references('id')
                ->on('recursos_sistema')
                ->onDelete('cascade')
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
        Schema::dropIfExists('pessoas_dados_acesso');
        Schema::dropIfExists('pessoas_dados_gerais');
        Schema::dropIfExists('pessoas_dados_contato');
        Schema::dropIfExists('pessoas_dados_academicos');
        Schema::dropIfExists('pessoas_dados_administrativos');
        Schema::dropIfExists('pessoas_dados_clinicos');
        Schema::dropIfExists('pessoas_dados_financeiros');
        Schema::dropIfExists('pessoas');

    }
}
