<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\HasDatabaseNotifications;
use Illuminate\Notifications\Notifiable;

class NomMoneda extends Model
{
    use Notifiable;

    //** table data */
    protected $table='NomMoneda';
    protected $primaryKey = 'idNomMoneda';

    //**relationships */
    public function  detaliiProgramarePlataManual(){
        return $this->hasMany('App\NomMoneda','idMoneda','idNomMoneda');
    }

}
