<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRequisicoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisicoes', function (Blueprint $table) {
            $table->date('data_questionado')->nullable()->after('ativo');
            $table->date('data_respondido')->nullable()->after('data_questionado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisicoes', function (Blueprint $table) {
            $table->dropColumn('data_questionado');
            $table->dropColumn('data_respondido');
        });
    }
}
