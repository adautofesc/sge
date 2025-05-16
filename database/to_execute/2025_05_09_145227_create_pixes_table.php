<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pix', function (Blueprint $table) {
            $table->id();
           
            $table->foreign('boleto')->
                references('id')->
                on('boletos')->
                onDelete('cascade')->
                onUpdate('cascade');
            $table->string('txid',35);
            $table->string('url',256);
            $table->string('emv',512);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pix');
    }
};
