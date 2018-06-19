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
use App\NomPartener;

class DetaliuProgramarePlataController extends Controller
{
    public function create(Request $request){
        $dppmanual = DetaliuProgramarePlataManual::create([
            'numarOp'=>$request->numarOp,
            'programare_platas_id'=>$request->programare_platas_id,
            'partener'=>$request->partener,
            'descriere'=>$request->explicatii,
            'valoare'=>$request->valoare,
            
        ]);
       
        $dppId = $dppmanual->id;
        $dppreturned = DetaliuProgramarePlataManual::find($dppId);
        $cont = '';
    
        return response()->json(['detaliualtele' =>$dppreturned,'cont'=>$cont]);
    }

    public function createf(Request $request){
        $partener = NomPartener::find($request->idPartener,['DenumirePartener']);
        $partener = $partener['DenumirePartener'];

        $dppmanual = DetaliuProgramarePlataManual::create([
            'programare_platas_id'=>$request->programare_platas_id,
            'partener'=>$partener,
            'descriere'=>$request->descriere,
            'valoare'=>$request->valoare,
            'numarOp'=>$request->numarOp,
            'idPartener'=>$request->idPartener,
            'idContBaza'=>$request->idContBaza
        ]);


        $dppId = $dppmanual->id;
        $dppreturned = DetaliuProgramarePlataManual::find($dppId);
        $cont = DB::table('NomBancaPartener')
                        ->where('idNomBancaPartener',$dppreturned->idContBaza)
                        ->value('ContBanca');

    
       return response()->json(['detaliualtele' =>$dppreturned,'cont'=>$cont]);
    }

    public function delete($id){
        $dppmanual = DetaliuProgramarePlataManual::find($id);
        $dppmanual->delete();

    }

    public function getParteneri(){
        $query = "
            select
                pp.idNomPartener as idPartener,
                ltrim(rtrim(pp.DenumirePartener)) as denumire
            from
                dbo.NomPartener pp
            where
                pp.idNomPartener <> 0
            order by
                pp.DenumirePartener
        ";

        $results = DB::select($query);

        return response()->json(['parteneri'=>$results]);
    }

    public function getConturiBancare($id){
        $query = "
        select
            cb.idNomBancaPartener as id,
            ltrim(rtrim(cb.ContBanca)) as cont,
            cb.Implicita as implicit
        from
            dbo.NomBancaPartener cb
        where
            cb.idNomPartener = $id
        ";

        $results = DB::select($query);

        return response()->json(['conturi'=>$results]);
    }
}
