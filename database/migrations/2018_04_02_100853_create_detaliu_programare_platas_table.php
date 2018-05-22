<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetaliuProgramarePlatasTable extends Migration
{

    public function up()
    {
        Schema::create('detaliu_programare_platas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('programare_platas_id');
            $table->string('idContContabil')->collation = 'SQL_Romanian_CP1250_CI_AS';
            $table->integer('idNomDocument');
            $table->string('numarDocument');
            $table->dateTime('dataDocument');
            $table->integer('idPartener');
            $table->dateTime('dataScadenta');
            $table->decimal('zileDepasite',8,0);
            $table->integer('idAdresaEx');
            $table->integer('tvaLaIncasare');
            $table->decimal('sold',11,2);
            $table->integer('cont_baza_id')->nullable();
            $table->integer('cont_tva_id')->nullable();
            $table->decimal('plataTotal',11,2);
            $table->decimal('plataBaza',11,2);
            $table->decimal('plataTva',11,2);
            $table->integer('numarOp')->nullable();;
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('status');
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('detaliu_programare_platas');
    }
    
}
