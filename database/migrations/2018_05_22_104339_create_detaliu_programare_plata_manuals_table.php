<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetaliuProgramarePlataManualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detaliu_programare_plata_manuals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('programare_platas_id');
            $table->string('partener');
            $table->string('descriere');
            $table->integer('idMoneda');
            $table->numeric('valoare');
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
        Schema::dropIfExists('detaliu_programare_plata_manuals');
    }
}
