<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contatos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('para');
            $table->unsignedInteger('por');
            $table->enum('meio',['pessoal','carta','telefone','email','sms','whatsapp']);
            $table->string('mensagem',300);
            $table->dateTime('data');
            $table->foreign('para')->references('id')->on('pessoas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contatos');
    }
}
