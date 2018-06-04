<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class DetaliuProgramarePlataManual extends Model
{
    
    use Notifiable;

    //table name & primary key
    protected $table = 'detaliu_programare_plata_manuals';
    protected $primaryKey = 'id';

    //add fields that can be changed
    protected $fillable = [
        'programare_platas_id','partener','descriere','idMoneda','valoare','verificare','created_by','updated_by','numarOp'
    ];

    //relationships
    public function programarePlata(){
        return $this->belongsTo('App\ProgramarePlata','programare_platas_id','id');
    }

    public function moneda(){
        return $this->belongsTo('App\NomMoneda','idMoneda','idNomMoneda');
    }


}
