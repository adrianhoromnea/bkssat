<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\ProgramarePlata;
use App\NomContBanca;
use App\FnExtrasBanca;
use App\PlanConturi;
use App\Workarounds\Utilities;
use App\DetaliuProgramarePlata;
use JavaScript;
use Auth;
use Session;
use DB;
use Validator;
use App\Services\UpdateAnafData;
use App\Services\GetDocumentsInfo;

class test extends Controller
{
    public function test(){
        /*
        $idProgramare = DB::table('dbo.detaliu_programare_platas')
        ->where('id',2748)
        ->select('programare_platas_id')
        ->get();
        */

        $ddd = DetaliuProgramarePlata::find(2748)->programare_platas_id;
       // $idProgramare = $ddd->programarePlata()->get();
        echo $ddd;
    }

    public function getAnafData(){
       $cui = '37401389';
       // $cui = '1234';

        //**define array for post fields */
        $postfields = [];
        //$postfields[] = ['cui'=>$cui, 'data'=>date('Y-m-d')];  
        
            array_push($postfields,
            ["cui"=>"555",
            "data"=>date('Y-m-d')]
            );

        
            array_push($postfields,
            ["cui"=>"255555",
            "data"=>date('Y-m-d')]
            );



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
        dd($data);

        /*
        if(!$data){
            $r = "eroare";
        }else{
            if($data['message'] != "SUCCESS" || $data['found'][0]['denumire'] == ''){
                $r = "eroare";
            }else{
                $r = $data['found'][0]; 
            }     
        }

        dd($r);
        return $r;
        */
    }

    public function setArray(){
        $ar1 = array();

        array_push($ar1,
            ["cont"=>"555",
            "data"=>'1']
        );

        
        array_push($ar1,
            ["cont"=>"255555",
            "data"=>'55']
        );

 
        


        dd($ar1);
    }

    public function updateSplitTva(){
        UpdateAnafData::updateDetaliiPpSplit(10);
    }

    public function getDataDocument(){
      $nnn =  GetDocumentsInfo::getBazaTvaValues(58,31,'12552','2018-04-26');
      echo $nnn['baza'];
    }
        

}
