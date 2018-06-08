<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBolsasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bolsas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pessoa');
            $table->unsignedInteger('curso')->nullable();
            $table->unsignedInteger('desconto');
            $table->unsignedInteger('programa')->nullable();
            $table->string('processo',30)->nullable();
            $table->enum('status',['analisando','indefirida','ativa','cancelada','expirada']);
            $table->string('obs',500)->nullable();
            $table->date('validade')->nullable();
            $table->timestamps();
            $table->foreign('pessoa')->references('id')->on('pessoas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('curso')->references('id')->on('cursos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('programa')->references('id')->on('programas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('desconto')->references('id')->on('descontos')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bolsas');
    }
}
