<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class BksDateFinante extends Model
{
    use Notifiable;

    //table name & primary key
    protected $table = 'bks_date_finantes';
    protected $primaryKey = 'id';

    //add fields that can be changed
    protected $fillable = [
        'idPartener','cui','dataCerere','denumireFirma','adresa','platitorScpTva','dataInceputScopTva','dataSfarsitScopTva','dataAnImpScpTVA','mesajScpTVA','dataInceputTvaInc','dataSfarsitTvaInc','dataActualizareTvaInc','dataPublicareTvaInc','tipActTvaInc','statusTvaIncasare','dataInactivare','dataReactivare','dataPublicare','dataRadiere','statusInactivi','dataInceputSplitTVA','dataAnulareSplitTVA','statusSplitTVA'
    ];

    //**relationships */
    public function partener(){
        return $this->belongsTo('App\NomPartener','idPartener','idNomPartener');
    }
}
