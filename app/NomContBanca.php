<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NomContBanca extends Model
{
    //table name
    protected $table = 'NomContBanca';
    protected $primaryKey = 'IdNomContBanca';

    //relationships
    public function listePlati(){
       return $this->hasMany('App\ProgramarePlata','cont_id','idContNomBanca');
    }

    public function contContabil(){
        return $this->belongsTo('App\PlanConturi','idCont','IdCont');
    }

    public function extraseBanca(){
        return $this->hasMany('App\FnExtrasBanca','IdContBanca','idNomContBanca');
    }
    
}
