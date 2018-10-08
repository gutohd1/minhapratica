<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 30);
            $table->string('sobrenome', 30);
            $table->string('email', 60);
            $table->string('endereco1', 50);
            $table->string('endereco2', 50)->nullable();
            $table->string('cidade', 50);
            $table->string('estado', 50)->nullable();
            $table->string('pais', 30);
            $table->integer('tipo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
