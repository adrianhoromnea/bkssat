<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanConturi extends Model
{
    //table name
    protected $table = 'NomPlanCont';

    //relationships
    public function conturiBancare(){
        return  $this->hasMany('App\NomContBanca','idCont','IdCont');
    }
}
