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
            $table->integer('numarOp');
            $table->integer('programare_platas_id');
            $table->string('partener')->nullable();
            $table->string('descriere')->nullable();
            $table->integer('idMoneda')->default('4');
            $table->decimal('valoare',11,2);
            $table->integer('verificare')->default('0');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
