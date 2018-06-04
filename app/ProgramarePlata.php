<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ProgramarePlata extends Model
{
    use Notifiable;
    //table name
    protected $table = 'programare_platas';
    protected $primaryKey = 'id';

    //add fields that can be changed
    protected $fillable = [
        'number','data','description','cont_id','extrascont_id','status','status_at','status_by','updated_by','created_by','startnumber'
    ];



    //relationships
    public function cont(){
        $this -> belongsTo('App\NomContBanca','cont_id','idContNomBanca');
    }

    public function extras(){
        $this -> belongsTo('App\FnExtrasBanca','extrascont_id','idExtrasBanca');
    }

    public function creater(){
        $this->belongsTo('App\User','created_by','id');
    }

    public function updater(){
        $this->belongsTo('App\User','updated_by','id');
    }

    public function approver(){
        $this->belongsTo('App\User','status_by','id');
    }

    public function detaliiProgramarePlata(){
        $this->hasMany('App\DetaliuProgramarePlata','programare_platas_is','id');
    }

    public function detaliiProgramarePlataManual(){
        return $this->hasMany('App\DetaliuProgramarePlataManual','programare_platas_id','id');
    }

}
