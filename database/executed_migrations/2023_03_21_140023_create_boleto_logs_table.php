<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoletoLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boleto_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('boleto');
            $table->string('evento',200);
            $table->dateTime('data');
            $table->unsignedInteger('pessoa');
            $table->foreign('boleto')->references('id')->on('boletos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('pessoa')->references('id')->on('pessoas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boleto_logs');
    }
}
