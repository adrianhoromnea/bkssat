<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FnExtrasBanca extends Model
{
    //table name
    protected $table = 'FnExtrasBanca';
    protected $primaryKey = 'idExtrasBanca';

    //**abort timestamps */
    public $timestamps = false;

    //**declare fields fillable */
    protected $fillable = [
        'idPunctLucru','idUtilizatorProprietar','idUtilizatorUltim','DataUtilizatorProprietar','DataUtilizatorUltim','Numar','Data','DeLa','PanaLa','Observatie','IdContBanca','An','Luna','AnLuna'
    ];

    //relationships
    public function listePlati(){
        return $this->hasMany('App\ProgramarePlata','extrascont_id','idExtrasBanca');
    }

    public function contBanca(){
        return $this->belongsTo('App\NomContBanca','IdContBanca','IdNomContBanca');
    }

    public function utilizatorErpInit(){
        return $this->belongsTo('App\tuser','idUtilizatorProprietar','IdUser');
    }

    public function utilizatorErpUltim(){
        return $this->belongsTo('App\tuser','idUtilizatorUltim','IdUser');
    }
}
