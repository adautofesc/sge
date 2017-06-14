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
    {
        Schema::create('pessoas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->char('sexo');
            $table->date('nascimento');
            $table->timestamps('created');
        });
        Schema::create('pessoas_dados_gerais', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dado');
            $tabel->string('valor',150);
            $table->timestamps('created');
        });
        Schema::create('pessoas_dados_contato', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dado');
            $tabel->string('valor',150);
            $table->timestamps('created');
        });
        Schema::create('pessoas_dados_academicos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dado');
            $tabel->string('valor',150);
            $table->timestamps('created');
        });
        Schema::create('pessoas_dados_administrativos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dado');
            $tabel->string('valor',150);
            $table->timestamps('created');
        });
        Schema::create('pessoas_dados_clinicos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dado');
            $tabel->string('valor',150);
            $table->timestamps('created');
        });
        Schema::create('pessoas_dados_financeiros', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dado');
            $tabel->string('valor',150);
            $table->timestamps('created');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pessoas');
        Schema::dropIfExists('pessoas_dados_gerais');
        Schema::dropIfExists('pessoas_dados_contato');
        Schema::dropIfExists('pessoas_dados_academicos');
        Schema::dropIfExists('pessoas_dados_administrativos');
        Schema::dropIfExists('pessoas_dados_clinicos');
        Schema::dropIfExists('pessoas_dados_financeiros');

    }
}
