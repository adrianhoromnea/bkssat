<?php

namespace App\Services;

use Auth;
use Session;
use DB;
use App\NomPartener;
use App\BksDateFinante;
use App\DetaliuProgramarePlata;

class UpdateAnafData{  
    public static function insertAnafData($idProgramarePlata){
        //**insert ANAF Data on demand */

        //**get parteners */
        $parteneri=DB::table('detaliu_programare_platas')
            ->join('NomPartener','detaliu_programare_platas.idPartener','=','idNomPartener')
            ->join('NomLocalitate','NomPartener.idNomLocalitate','=','NomLocalitate.idNomLocalitate')
            ->join('NomJudet','NomLocalitate.idNomJudet','=','NomJudet.idNomJudet')
            ->join('NomTara','NomJudet.IdTara','=','NomTara.idNomTara')
            ->select('NomPartener.CodIdentificareFiscala as cui',
              DB::raw("'" . date('Y-m-d') . "' as data"))
            ->distinct()
            ->where('programare_platas_id',$idProgramarePlata)
            ->where('NomTara.idNomTara','2')
            ->orderBy('NomPartener.CodIdentificareFiscala','asc')
            ->take(499)
            ->get();

        $results = self::getAnafData($parteneri);
        $results = $results['found'];

        if($results){
            foreach ($results as $result){
                //**getIdPartener */
                $parteneriId = DB::table('NomPartener')
                    ->distinct()
                    ->select('idNomPartener')
                    ->where('CodIdentificareFiscala',strval($result['cui']))
                    ->get();
                foreach($parteneriId as $idPartener){
                    if($idPartener->idNomPartener != "" || $idPartener->idNomPartener != 0){
                    //**get daat into array */
                    $anafData = array();
                    $anafData['idPartener'] = $idPartener->idNomPartener;
                    $anafData['cui'] = $result['cui'];
                    $anafData['dataCerere'] = $result['data'];
                    $anafData['denumireFirma'] = $result['denumire'];
                    $anafData['adresa'] = $result['adresa'];
                    $anafData['platitorScpTva'] = $result['scpTVA'];
                    $anafData['dataInceputScopTva'] = $result['data_inceput_ScpTVA'];
                    $anafData['dataSfarsitScopTva'] = $result['data_sfarsit_ScpTVA'];
                    $anafData['dataAnImpScpTVA'] = $result['data_anul_imp_ScpTVA'];
                    $anafData['mesajScpTVA'] = $result['mesaj_ScpTVA'];
                    $anafData['dataInceputTvaInc'] = $result['dataInceputTvaInc'];
                    $anafData['dataSfarsitTvaInc'] = $result['dataSfarsitTvaInc'];
                    $anafData['dataActualizareTvaInc'] = $result['dataActualizareTvaInc'];
                    $anafData['dataPublicareTvaInc'] = $result['dataPublicareTvaInc'];
                    $anafData['tipActTvaInc'] = $result['tipActTvaInc'];
                    $anafData['statusTvaIncasare'] = $result['statusTvaIncasare'];
                    $anafData['dataInactivare'] = $result['dataInactivare'];
                    $anafData['dataReactivare'] = $result['dataReactivare'];
                    $anafData['dataPublicare'] = $result['dataPublicare'];
                    $anafData['dataRadiere'] = $result['dataRadiere'];
                    $anafData['statusInactivi'] = $result['statusInactivi'];
                    $anafData['dataInceputSplitTVA'] = $result['dataInceputSplitTVA'];
                    $anafData['dataAnulareSplitTVA'] = $result['dataAnulareSplitTVA'];
                    $anafData['statusSplitTVA'] = $result['statusSplitTVA'];

                    //**call  create function */
                   self::createAnafRecord($anafData);
                }
                }
             }
        }
    }

    protected static function getAnafData($parteneri){
         $postfields = $parteneri;
 
         //**define url */
         $url='https://webservicesp.anaf.ro:/PlatitorTvaRest/api/v3/ws/tva';
 
         //**define header */
         $header = ["Content-Type: application/json"];
 
         //**initialize cURL session */
         $ch = curl_init();
 
         //**set cURL options */
         curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; MSIE 7.01; Windows NT 5.0)Chrome/22.0.1216.0");
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
         curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
         curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 130);
         curl_setopt($ch, CURLOPT_TIMEOUT, 130);
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_POST,TRUE);
         curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($postfields));
 
         //**get result */
         $result = curl_exec($ch);
 
         //**close cURL */
         curl_close($ch);
 
         //**get data */
         $data = json_decode($result,true);
 
         //**return */
         $r = $data;
         return $r;
    }

    protected static function createAnafRecord($anafData){
        //**insert new record into bks_date_finante */
        
        BksDateFinante::updateOrCreate(['idPartener'=>$anafData['idPartener'],'dataCerere'=>$anafData['dataCerere']],[
            'idPartener'            =>$anafData['idPartener'],
            'cui'                   =>$anafData['cui'],
            'dataCerere'            =>$anafData['dataCerere'],
            'denumireFirma'         =>$anafData['denumireFirma'],
            'adresa'                =>$anafData['adresa'],
            'platitorScpTva'        =>$anafData['platitorScpTva'],
            'dataInceputScopTva'    =>$anafData['dataInceputScopTva'],
            'dataSfarsitScopTva'    =>$anafData['dataSfarsitScopTva'],
            'dataAnImpScpTVA'       =>$anafData['dataAnImpScpTVA'],
            'mesajScpTVA'           =>$anafData['mesajScpTVA'],
            'dataInceputTvaInc'     =>$anafData['dataInceputTvaInc'],
            'dataSfarsitTvaInc'     =>$anafData['dataSfarsitTvaInc'],
            'dataActualizareTvaInc' =>$anafData['dataActualizareTvaInc'],
            'dataPublicareTvaInc'   =>$anafData['dataPublicareTvaInc'],
            'tipActTvaInc'          =>$anafData['tipActTvaInc'],
            'statusTvaIncasare'     =>$anafData['statusTvaIncasare'],
            'dataInactivare'        =>$anafData['dataInactivare'],
            'dataReactivare'        =>$anafData['dataReactivare'],
            'dataPublicare'         =>$anafData['dataPublicare'],
            'dataRadiere'           =>$anafData['dataRadiere'],
            'statusInactivi'        =>$anafData['statusInactivi'],
            'dataInceputSplitTVA'   =>$anafData['dataInceputSplitTVA'],
            'dataAnulareSplitTVA'   =>$anafData['dataAnulareSplitTVA'],
            'statusSplitTVA'        =>$anafData['statusSplitTVA']  
        ]);
    }

    public static function updateDetaliiPpSplit($idProgramarePlata){
        //**update column "splitTva" from "detaliu_programare_platas" */

        $maxDate = DB::table('bks_date_finantes')
            ->max('dataCerere');

        $detalii = DB::table('detaliu_programare_platas')
            ->where('programare_platas_id',$idProgramarePlata)
            ->get();

        foreach($detalii as $detaliu){
            $idPartener = $detaliu->idPartener;
            
            $splitTva = DB::table('bks_date_finantes')
                ->distinct()
                ->where('idPartener',$idPartener)
                ->where('dataCerere',$maxDate)
                ->select('statusSplitTVA')
                ->get();
            
            if($splitTva->first()){
                $splitTva = $splitTva->first()->statusSplitTVA;
            }else{
                $splitTva = 3; //0=nu;1=da;3=noData
            }

            DB::table('detaliu_programare_platas')
            ->where('id',$detaliu->id)
            ->update(['splitTva'=>$splitTva]);

        }


    }

}