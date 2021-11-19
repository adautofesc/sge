<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendaAtendimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda_atendimentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('pessoa');
            $table->date('data');
            $table->time('horario');
            /*$table->enum('horario',['15:15','8:30','8:45','9:00','9:15','9:30','9:45','10:00','10:15','10:30','10:45','11:00','11:00','11:15',
                                    '14:00','14:15','14:30','14:45','15:00','15:15','15:30','15:45','16:00','16:15','16:30','16:45','17:00','17:15','17:30','17:45','18:00','18:15']);*/
            $table->unsignedInteger('atendente');
            $table->enum('status',['aguardando','cancelado','atendido','faltou']);
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agenda_atendimentos');
    }
}
