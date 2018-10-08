<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emails',function(Blueprint $table){         
            $table->integer('bloqueado')->after('tipo');
            $table->integer('envio')->after('bloqueado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('emails',function(Blueprint $table){         
            $table->dropColumn(['bloqueado', 'envio']);
        });
    }
}
