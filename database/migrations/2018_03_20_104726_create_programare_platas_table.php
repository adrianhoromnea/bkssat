<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramarePlatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programare_platas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number');
            $table->integer('startnumber');
            $table->dateTime('data');
            $table->string('description')->nullable();;
            $table->string('cont_id')->collation = 'SQL_Romanian_CP1250_CI_AS';
            $table->string('extrascont_id')->collation = 'SQL_Romanian_CP1250_CI_AS';
            $table->integer('status')->default('0'); //0 = draft; 1=sent; 2=aproved; 3=declined; 4=generated; 5=aborted;
            $table->dateTime('aproved_at')->nullable();
            $table->integer('aproved_by')->nullable();
            $table->integer('updated_by');
            $table->integer('created_by');
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
        Schema::dropIfExists('programare_platas');
    }
}
