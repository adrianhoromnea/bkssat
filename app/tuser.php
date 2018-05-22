<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tuser extends Model
{
    //table name
    protected $table = 'TUser';

    //**primaryKey */
    protected $primaryKey = 'IdUser';

    //relationships
    public function user(){
        return $this->hasOne('App\User','erpuser_id','IdUser');
    }

    public function extrasInit(){
        return $this->hasMany('App\FnExtrasBanca','idUtilizatorProprietar','IdUser');
    }

    public function extrasUltim(){
        return $this->hasMany('App\FnExtrasBanca','idUtilizatorUltim','IdUser');
    }
}
