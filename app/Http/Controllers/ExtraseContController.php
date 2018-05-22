<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;
use Response;
use Auth;
use Session;

use App\FnExtrasBanca;
use App\Workarounds\Utilities;


class ExtraseContController extends Controller
{
    public function showCreate()
    {
        //**show create modal form */
    }
    public function index()
    {
        //
    }



    public function create(Request $request)
    {
        //**initialise other classes */
        $utilities = new Utilities;

       //**validations */
        $rules=array(
            'data'=>'required|date_format:"Y-m-d"',
            'deLa'=>'required|date_format:"Y-m-d"',
            'panaLa'=>'required|date_format:"Y-m-d"',
            'numar'=>'required|numeric|unique:FnExtrasBanca,numar,NULL,idExtrasBanca,Data,' . $request->data
        );
        $validator = Validator::make(input::all(),$rules);

        if($validator->fails()){
            return response()->json(array('errors'=>$validator->getMessageBag()->toarray()));
        }
        else{
            $extras = FnExtrasBanca::create([
                'idPunctLucru'=>'1',
                'idUtilizatorProprietar'=>Auth::user()->tuser->IdUser,
                'idUtilizatorUltim'=>Auth::user()->tuser->IdUser,
                'DataUtilizatorProprietar'=>date('Y-m-d h:i:s'),
                'DataUtilizatorUltim'=>date('Y-m-d h:i:s'),
                'Numar'=>$request->numar,
                'Data'=>$request->data,
                'DeLa'=>$request->deLa,
                'PanaLa'=>$request->panaLa,
                'Observatie'=>is_null($request->observatie) ? '' : $request->observatie,
                'IdContBanca'=>$request->idContBanca,
                'An'=>$utilities->getDateInfo($request->data,'y'),
                'Luna'=>$utilities->getDateInfo($request->data,'m'),
                'AnLuna'=>$utilities->getDateInfo($request->data,'ym'),
            ]);
        
            return response()->json($extras);
        }


       //echo "e ok"


        //**teste */
        /*
        $extras = FnExtrasBanca::create([
            'idPunctLucru'=>'1',
            'idUtilizatorProprietar'=>'36',
            'idUtilizatorUltim'=>'36',
            'DataUtilizatorProprietar'=>'2018-03-28',
            'DataUtilizatorUltim'=>'2018-03-28',
            'Numar'=>'22',
            'Data'=>'2018-03-28',
            'DeLa'=>'2018-03-28',
            'PanaLa'=>'2018-03-28',
            'Observatie'=>'nnn',
            'IdContBanca'=>'_2FF0WFTUH',
            'An'=>'2018',
            'Luna'=>'3',
            'AnLuna'=>'201803'
        ]);
        */

     //  echo 'nnn';

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
