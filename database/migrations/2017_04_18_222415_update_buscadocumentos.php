<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBuscadocumentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buscasdocumentos', function (Blueprint $table) {
            $table->string('msgtitulo', 50)->after('linkdoc');
            $table->longText('msg');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buscasdocumentos', function (Blueprint $table) {
            $table->dropColumn('msgtitulo');
            $table->dropColumn('msg');
        });
    }
}
