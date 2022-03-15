<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDividaAtivaLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('divida_ativa_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('divida');
            $table->string('registro',300);
            $table->unsignedInteger('responsavel');
            $table->timestamps();
            $table->foreign('responsavel')->
                references('id')->
                on('pessoas')->
                onDelete('cascade')->
                onUpdate('cascade');
            $table->foreign('divida')->
                references('id')->
                on('divida_ativa')->
                onDelete('cascade')->
                onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('divida_ativa_logs');
    }
}
