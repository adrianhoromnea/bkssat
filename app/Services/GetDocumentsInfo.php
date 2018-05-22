<?php

namespace App\Services;

use Auth;
use Session;
use DB;

class GetDocumentsInfo {

    public static function getBazaTvaValues($idPartener,$idNomDocument,$numarDocument,$dataDocument){
        /*
        $idPartener = 799;
        $idNomDocument = 20;
        $numarDocument = '7010070';
        $dataDocument = '2018-04-26 00:00:00.000';
        */

        $idDocument = self::getIdTabelaDocument($idPartener,$idNomDocument,$numarDocument,$dataDocument,'idDocument');
        $idTabela = self::getIdTabelaDocument($idPartener,$idNomDocument,$numarDocument,$dataDocument,'idTabela');
        //dd($idTabela);
        if($idDocument != 'noData' && $idTabela != 'noData'){

            $results = self::getValoriDocument($idNomDocument,$idDocument,$idTabela,$idPartener,$numarDocument,$dataDocument);
            if($results){
                foreach($results as $result){
                    $r = array();

                    if($result->tip == 'baza'){
                        $baza = $result->valoare;
                    }else if($result->tip == 'tva'){
                        $tva = $result->valoare;
                    }                  
                }
            }

            $r['baza'] = !$baza ? 0 : $baza; 
            $r['tva'] = !$tva ? 0 : $tva;

        }

        return !$r ? 'nodata' : $r;
    }

    protected static function getIdTabelaDocument($idPartener,$idNomDocument,$numarDocument,$dataDocument,$type){
        //** $type = "idTabela" || "idDocument" */
        $query = "SELECT TOP 1 S." . $type . " AS id
                FROM
                (SELECT 
                    idTabela, 
                    idDocument 
                 FROM 
                    TranzactiePartenerIn 
                WHERE idPartener = $idPartener AND idNomDocument = $idNomDocument AND NumarDocument = '$numarDocument' AND DataDocument = '" . $dataDocument . "' AND idNomDocumentCor = $idNomDocument AND NumarDocumentCor = '$numarDocument' AND DataDocumentCor = '" . $dataDocument . 
                "' UNION ALL
                SELECT 
                    idTabela, 
                    idDocument 
                FROM 
                    TranzactiePartenerOut 
                WHERE idPartener = $idPartener AND idNomDocument = $idNomDocument AND NumarDocument = '$numarDocument' AND DataDocument = '" . $dataDocument . "' AND idNomDocumentCor = $idNomDocument AND NumarDocumentCor = '$numarDocument' AND DataDocumentCor = '" . $dataDocument . "') S
                WHERE S.idTabela ! = 6
        ";

        $r = DB::select($query);

        if($r){
            $r = $r[0]->id;
        }else{
            $r = "nodata";
        }

        return $r;
        
    }

    protected static function getValoriDocument($idNomDocument,$idDocument,$idTabela,$idPartener,$numarDocument,$dataDocument){
        switch($idNomDocument){
            case 31:
                $query = "SELECT
                    'baza' as tip,
                    sum(f.ValoareFactura) AS valoare
                FROM 
                    dbo.AprFacturaFurnizorExterna f
                WHERE
                    f.IdPartener = $idPartener
                AND
                    f.numar = '" . $numarDocument . "'
                AND
                    f.Data = '" . $dataDocument . "'
                UNION ALL
                SELECT
                    'tva' as tip,
                    sum(f.ValoareTVA) AS valoare
                FROM 
                    dbo.AprFacturaFurnizorExterna f
                WHERE
                    f.IdPartener = $idPartener
                AND
                    f.numar = '" . $numarDocument . "'
                AND
                    f.Data = '" . $dataDocument . "'
                
                ";
                $r = DB::select($query);
            break;

            default:
                $query = "SELECT DISTINCT 
                    s1.tip as tip,
                    sum(s1.valoare) as valoare
                FROM
                (SELECT DISTINCT
                    CASE pc.SimbolCont
                        WHEN '4428.69' THEN 'tva' 
                        WHEN '4428.29' THEN 'tva'
                        WHEN '4428.30' THEN 'tva'
                        WHEN '4428.31' THEN 'tva'
                        WHEN '4428.39' THEN 'tva'
                        WHEN '4426.05' THEN 'tva'
                        WHEN '4426.09' THEN 'tva'
                        WHEN '4426.19' THEN 'tva'
                        WHEN '4426.20' THEN 'tva'
                        ELSE 'baza'
                    END as tip,
                    Valoare as valoare
                FROM
                    dbo.NomTranzactieNC nc INNER JOIN dbo.NomPlanCont pc on nc.idContD = pc.IdCont INNER JOIN dbo.NomPlanCont pc2 on nc.idContC = pc2.IdCont
                WHERE
                    idDocument = $idDocument
                AND
                    idTabela = $idTabela
                AND
                    IdNomDocument = $idNomDocument) s1
                GROUP BY
                    s1.tip
                ";
                $r = DB::select($query);


        }


        if($r){
            $r = $r;
        }else{
            $r = "nodata";
        }

        return $r;
    }


}
