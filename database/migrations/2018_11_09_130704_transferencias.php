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
        //

        Schema::create('transferencias', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pessoa');
            $table->unsignedInteger('insc_anterior');
            $table->unsignedInteger('insc_atual');
            $table->unsignedInteger('atendimento');
            $table->timestamps();
            $table->foreign('pessoa')->references('id')->on('pessoas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('insc_anterior')->references('id')->on('inscricoes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('insc_atual')->references('id')->on('inscricoes')->onDelete('cascade')->onUpdate('cascade');
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
