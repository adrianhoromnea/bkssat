<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;



class DetaliuProgramarePlata extends Model
{
    use Notifiable;

    //table name
    protected $table = 'detaliu_programare_platas';
    protected $primaryKey = 'id';

    //add fields that can be changed
    protected $fillable = [
        'programare_platas_id','idContContabil','idNomDocument','numarDocument','dataDocument','idPartener','dataScadenta','zileDepasite','idAdresaEx','tvaLaIncasare','sold','cont_baza_id','cont_tva_id','plataTotal','plataBaza','plataTva','created_by','updated_by','status'
    ];

    //**relationships */
    public function programarePlata(){
        return $this->belongsTo('App\ProgramarePlata','programare_platas_is','id');
    }

    public function partener(){
        return $this->belongsTo('App\NomPartener','idPartener','idNomPartener');
    }

}
