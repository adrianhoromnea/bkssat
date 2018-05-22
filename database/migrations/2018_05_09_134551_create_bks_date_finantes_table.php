<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBksDateFinantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bks_date_finantes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idPartener');
            $table->string('cui')->nullable();
            $table->dateTime('dataCerere')->nullable();
            $table->string('denumireFirma')->nullable();
            $table->string('adresa')->nullable();
            $table->boolean('platitorScpTva')->nullable();
            $table->dateTime('dataInceputScopTva')->nullable();
            $table->dateTime('dataSfarsitScopTva')->nullable();
            $table->dateTime('dataAnImpScpTVA')->nullable();
            $table->string('mesajScpTVA')->nullable();
            $table->dateTime('dataInceputTvaInc')->nullable();
            $table->dateTime('dataSfarsitTvaInc')->nullable();
            $table->dateTime('dataActualizareTvaInc')->nullable();
            $table->dateTime('dataPublicareTvaInc')->nullable();
            $table->string('tipActTvaInc')->nullable();
            $table->boolean('statusTvaIncasare')->nullable();
            $table->dateTime('dataInactivare')->nullable();
            $table->dateTime('dataReactivare')->nullable();
            $table->dateTime('dataPublicare')->nullable();
            $table->dateTime('dataRadiere')->nullable();
            $table->boolean('statusInactivi')->nullable();
            $table->dateTime('dataInceputSplitTVA')->nullable();
            $table->dateTime('dataAnulareSplitTVA')->nullable();
            $table->boolean('statusSplitTVA')->nullable();
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
        Schema::dropIfExists('bks_date_finantes');
    }
}
