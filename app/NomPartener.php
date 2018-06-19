<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BksDateFinante;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NomPartener extends Model
{
    use Notifiable;

    //table name & primary key
    protected $table = 'NomPartener';
    protected $primaryKey = 'idNomPartener';

    //**relationships */
    public function bksDateFinante(){
        return $this->hasMany('App\BksDateFinante','idPartener','idNomPartener');
    }

    public function detaliuProgramarePlata(){
        return $this->hasMany('App\DetaliuProgramarePlata','idPartener','idNomPartener');
    }

    public function detaliuProgramarePlataManual(){
        return $this->hasMany('App\NomPartener','idPartener','idNomPartener');
    }
}
