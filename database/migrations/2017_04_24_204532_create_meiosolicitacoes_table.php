<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeiosolicitacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meiosolicitacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->timestamps();
        });
        DB::table('meiosolicitacoes')->insert(
            array(
                'nome' => 'Email',
                'created_at' => Carbon::now('Europe/London'),
                'updated_at' => Carbon::now('Europe/London')
            )
        );
        DB::table('meiosolicitacoes')->insert(
            array(
                'nome' => 'Telefone',
                'created_at' => Carbon::now('Europe/London'),
                'updated_at' => Carbon::now('Europe/London')
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meiosolicitacoes');
    }
}
