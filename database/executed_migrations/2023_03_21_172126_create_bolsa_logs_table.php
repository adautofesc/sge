<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBolsaLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bolsa_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bolsa');
            $table->string('evento',200);
            $table->dateTime('data');
            $table->unsignedInteger('pessoa');
            $table->foreign('bolsa')->references('id')->on('bolsas')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('bolsa_logs');
    }
}
