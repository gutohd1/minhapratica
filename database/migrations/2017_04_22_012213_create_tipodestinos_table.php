<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipodestinosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipodestinos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 30);
            $table->string('class', 30);
            $table->timestamps();
        });
        DB::table('tipodestinos')->insert(
            array(
                'nome' => 'Comune',
                'class' => 'comunes',
                'created_at' => Carbon::now('Europe/London'),
                'updated_at' => Carbon::now('Europe/London')
            )
        );
        DB::table('tipodestinos')->insert(
            array(
                'nome' => 'Provincia',
                'class' => 'provincia',
                'created_at' => Carbon::now('Europe/London'),
                'updated_at' => Carbon::now('Europe/London')
            )
        );
        DB::table('tipodestinos')->insert(
            array(
                'nome' => 'Paroquia',
                'class' => 'paroquia',
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
        Schema::dropIfExists('tipodestinos');
    }
}
