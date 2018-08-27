<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatriculasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pessoa');
            $table->unsignedInteger('atendente');
            $table->string('status',2)->default('p');
            $table->string('forma_pgto',1);
            $table->unsignedInteger('parcelas');
            $table->unsignedInteger('dia_venc');
            $table->unsignedInteger('resp_financeiro')->nullable();
            $table->string('contrato',1);
            $table->string('termo',1);
            $table->timestamps();
            $table->foreign('pessoa')->references('id')->on('pessoas')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('atendente')->references('id')->on('pessoas')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('resp_financeiro')->references('id')->on('pessoas')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matriculas');
    }
}
