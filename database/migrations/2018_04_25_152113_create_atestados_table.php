<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtestadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atestados', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pessoa');
            $table->date('validade');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('pessoa')->references('id')->on('pessoas')->onDelete('restrict')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atestados');
    }
}
