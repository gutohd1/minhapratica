<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuscasdocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buscasdocumentos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipo');
            $table->string('nome', 40);
            $table->string('ano', 4);
            $table->string('conjuge', 40)->nullable();
            $table->string('pai', 40)->nullable();
            $table->string('mae', 40)->nullable();
            $table->integer('idbusca');
            $table->integer('localizado');
            $table->integer('idlocalizacao')->nullable();
            $table->integer('tipolocalizacao')->nullable();
            $table->string('linkdoc', 50)->nullable();
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
        Schema::dropIfExists('buscasdocumentos');
    }
}
