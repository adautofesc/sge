<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('htps', function (Blueprint $table) {
            $table->id();
            $table->integer('professor')->unsigned();
            $table->date('data');
            $table->bigInteger('professor_htp')->unsigned();
            $table->foreign('professor')->references('id')->on('pessoas')->onDelete('cascade');
            $table->string('conteudo');
            $table->enum('status',['ativo','inativo'])->default('ativo');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('htps');
    }
};
