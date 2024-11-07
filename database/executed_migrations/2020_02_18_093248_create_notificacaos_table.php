<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('de');
            $table->unsignedInteger('para');
            $table->unsignedInteger('dado');
            $table->enum('tipo',['encaminhamento','recebimento','transitando','pendencia_falta','pendencia_pagamento','suspensao_bolsista']);
            $table->string('valor',300);
            $table->enum('visualizado',['sim','não']);
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
        Schema::dropIfExists('notificacoes');
    }
}
