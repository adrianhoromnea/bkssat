<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDetaliuProgramarePlataCk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detaliu_programare_platas', function(Blueprint $table) {
            $table->integer('checked')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detaliu_programare_platas', function(Blueprint $table) {
            $table->dropColumn('checked');
        });
    }
}
