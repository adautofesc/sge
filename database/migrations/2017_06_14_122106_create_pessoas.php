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
    public function up()
    

        Schema::enableForeignKeyConstraints();

        Schema::create('pessoas', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('nome');
            $table->char('genero');
            $table->date('nascimento');
            $table->timestamps('created');
        });
        Schema::create('pessoas_dados_gerais', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('pessoa')->references('id')->on('pessoas');
            $table->unsignedInteger('dado');
            $table->string('valor',150);
            $table->timestamps('created');
        });
        Schema::create('pessoas_dados_contato', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('pessoa')->references('id')->on('pessoas');
            $table->unsignedInteger('dado');
            $table->string('valor',150);
            $table->timestamps('created');
        });
        Schema::create('pessoas_dados_academicos', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('pessoa')->references('id')->on('pessoas');
            $table->unsignedInteger('dado');
            $table->string('valor',150);
            $table->timestamps('created');
        });
        Schema::create('pessoas_dados_administrativos', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('pessoa')->references('id')->on('pessoas');
            $table->unsignedInteger('dado');
            $table->string('valor',150);
            $table->timestamps('created');
        });
        Schema::create('pessoas_dados_clinicos', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('pessoa')->references('id')->on('pessoas');
            $table->unsignedInteger('dado');
            $table->string('valor',150);
            $table->timestamps('created');
        });
        Schema::create('pessoas_dados_financeiros', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('pessoa')->references('id')->on('pessoas');
            $table->unsignedInteger('dado');
            $table->string('valor',150);
            $table->timestamps('created');
        });
        Schema::create('pessoas_dados_acesso', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('pessoa')->references('id')->on('pessoas')->unsigned();
            $table->string('usuario',15)->unique();
            $table->string('senha');
            $table->date('validade');
            $table->char('status',1);
            $table->rememberToken();
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
