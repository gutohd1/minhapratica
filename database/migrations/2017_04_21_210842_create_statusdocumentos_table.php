<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusdocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statusdocumentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 30);
            $table->timestamps();
        });
        DB::table('statusdocumentos')->insert(
            array(
                'nome' => 'Cancelado pelo cliente',
                'created_at' => Carbon::now('Europe/London'),
                'updated_at' => Carbon::now('Europe/London')
            )
        );
        DB::table('statusdocumentos')->insert(
            array(
                'nome' => 'Na fila para envio',
                'created_at' => Carbon::now('Europe/London'),
                'updated_at' => Carbon::now('Europe/London')
            )
        );
        DB::table('statusdocumentos')->insert(
            array(
                'nome' => 'Enviado',
                'created_at' => Carbon::now('Europe/London'),
                'updated_at' => Carbon::now('Europe/London')
            )
        );
        DB::table('statusdocumentos')->insert(
            array(
                'nome' => 'Respondido afirmaivamente',
                'created_at' => Carbon::now('Europe/London'),
                'updated_at' => Carbon::now('Europe/London')
            )
        );
        DB::table('statusdocumentos')->insert(
            array(
                'nome' => 'Respondido negativamente',
                'created_at' => Carbon::now('Europe/London'),
                'updated_at' => Carbon::now('Europe/London')
            )
        );
        DB::table('statusdocumentos')->insert(
            array(
                'nome' => 'Respondido sem definicao',
                'created_at' => Carbon::now('Europe/London'),
                'updated_at' => Carbon::now('Europe/London')
            )
        );
        DB::table('statusdocumentos')->insert(
            array(
                'nome' => 'Documento solicitado',
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
        Schema::dropIfExists('statusdocumentos');
    }
}
