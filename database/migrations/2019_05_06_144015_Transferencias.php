<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Transferencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferencias', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('matricula');
            $table->unsignedInteger('anterior');
            $table->unsignedInteger('nova');
            $table->dateTime('data');
            $table->unsignedInteger('pessoa');
            $table->foreign('pessoa')->references('id')->on('pessoas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('matricula')->references('id')->on('matriculas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('anterior')->references('id')->on('inscricoes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('nova')->references('id')->on('inscricoes')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
