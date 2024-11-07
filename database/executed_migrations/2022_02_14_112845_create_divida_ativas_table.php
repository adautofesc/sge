<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDividaAtivasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('divida_ativa', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('pessoa');
            $table->unsignedTinyInteger('incricao');
            $table->unsignedTinyInteger('folha');
            $table->unsignedInteger('valor_consolidado');
            $table->date('consolidado_em');
            $table->enum('status',['aberto','pago','remitido', 'executado','renegociado']);
            $table->softDeletes();
            $table->foreign('pessoa')->
                references('id')->
                on('pessoas')->
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
        Schema::dropIfExists('dividas_ativas');
    }
}
