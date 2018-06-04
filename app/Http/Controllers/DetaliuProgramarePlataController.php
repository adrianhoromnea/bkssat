<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use JavaScript;
use Auth;
use Session;
use DB;
use Validator;
use App\ProgramarePlata;
use App\DetaliuProgramarePlataManual;
use App\DetaliuProgramarePlata;

class DetaliuProgramarePlataController extends Controller
{
    public function create(Request $request){
        $dppmanual = DetaliuProgramarePlataManual::create([
                'programare_platas_id'=>$request->programare_platas_id,
                'partener'=>$request->partener,
                'descriere'=>$request->explicatii,
                'valoare'=>$request->valoare,
                'numarOp'=>$request->numarOp
            ]);

        $dppId = $dppmanual->id;
        $dppreturned = DetaliuProgramarePlataManual::find($dppId);
    
       return response()->json(['detaliualtele' =>$dppreturned]);
    }

    public function delete($id){
        $dppmanual = DetaliuProgramarePlataManual::find($id);
        $dppmanual->delete();

    }
}
