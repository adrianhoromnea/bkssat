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


class ProgramarePlatiController extends Controller
{

    //**global variables */
    protected $idsConturiBancare = array('_2FF0WFTUH');
    protected $idsExtraseCont = array();
    protected $idsConturiParteneri = array('401.01','404.01');
    
    //**Lista progreamari - CRUD & misc*/
    public function index()
    {
        //**return "lista programari" list */
        return view('financiar.programarePlati.listaprogramari');
    }

    public function showCreate()
    {
        //**show create new "lista programare"  form */

        //**get pp number */
        $numar = ProgramarePlata::max('number') + 1;
        if(!$numar){
            $numar = '1';
        }

        $conturi = NomContBanca::whereIn('IdNomContBanca',
                                    [$this->idsConturiBancare])
                                    ->get();

        return view('financiar.programarePlati.create')->with([
            'numar'=>$numar,
            'conturi'=>$conturi,
        ]);
    }

    public function create(Request $request)
    {
        //**Validate data */
        $this->validate($request,[
            'data'=>'required|date_format:"Y-m-d"',
            'numar'=>'required',
            'startNumar'=>'required|numeric',
            'cont'=>'required',
        ]);

        //**create new ProgramarePlati */
        $programarePlata = ProgramarePlata::create([
            'number'=>$request->numar,
            'startnumber'=>$request->startNumar,
            'data'=>$request->data,
            'description'=>$request->descriere,
            'cont_id'=>$request->cont,
            'extrascont_id'=>$request->extrasBanca,
            'status'=>'0',
            //'status_at'=>date('Y-m-d H:i:s'),
            'created_by'=>Auth::user()->id,
            'updated_by'=>Auth::user()->id,
        ]);

        //**insert detalii programare plata */
        $programare_platas_id = $programarePlata->id;
        $this->createDetaliiProgramarePlata($programare_platas_id,'initial');
        
        //**update date anaf */
        UpdateAnafData::insertAnafData($programare_platas_id);

        
        //**update splitTVA in detaliiProgramarePlata */
        UpdateAnafData::updateDetaliiPpSplit($programare_platas_id);


        //**return */
        $fmessage = "Programarea platii a fost creata cu succes!";
        Session::flash('success',$fmessage);

        return redirect()->route('showUpdateListaPp',['id'=>$programare_platas_id]);
        
    }

    public function showUpdate($id)
    {
        //**show update "lista programare"  form */

        //**initialise other classes */
        $utilities = new Utilities;

        //**data to be sent to update form */
        $programare = ProgramarePlata::find($id);

        //**define variables for utilities function */
        $utilities->selectedDate = $programare->data;

        //**prepare data to be sent to the form */
        $conturi = NomContBanca::whereIn('IdNomContBanca',
                                    [$this->idsConturiBancare])
                                    ->get();
        $extrase = FnExtrasBanca::where('IdContBanca',$programare->cont_id)
                                  ->where('AnLuna',$utilities->getAnLuna())
                                  ->orderBy('Numar','DESC')
                                  ->get();
        
        $status = $this->getStatusProgramare($programare->status);

        //**get detalii liste programari */

        $query = "select
            pp.id as id,
            pc.IdCont as idCont,
            pc.SimbolCont as simbolCont,
            np.idNomPartener as idPartener,
            ltrim(rtrim(np.DenumirePartener)) as denumirePartener,
            np.CodFiscal as codFiscal,
            bp.idNomBancaPartener as idBancaBaza,
            bp.ContBanca as contBaza,
            isnull(pp.cont_tva_id,0) as idContTVA,
            isnull(bp2.ContBanca,'')  as contTVA,
            nd.idDocument as idDocument,
            nd.Cod as tipDocument,
            pp.numarDocument as numarDocument,
            convert(char(10),pp.dataDocument,126) as dataDocument,
            convert(char(10),pp.dataScadenta,126) as dataScadenta,
            pp.zileDepasite as zileDepasite,
            pp.sold as sold,
            case pp.splitTva
                when 0  then 'nu'
                when 1  then 'da'
                when 3  then 'none'
                else 'null'
            end as splitTVA,
            pp.plataTotal as plataTotal,
            pp.plataBaza as plataBaza,
            pp.plataTva as plataTVA,
            pp.numarOp,
            pp.status,
            case pp.status
                when 0 then 'Initiala'
                when 1 then 'Generata'
            end as statusVal
        from
            dbo.detaliu_programare_platas pp inner join dbo.NomPlanCont pc
                on pp.idContContabil = pc.IdCont
            inner join dbo.NomPartener np
                on np.idNomPartener = pp.idPartener
            inner join dbo.NomBancaPartener bp
                on pp.cont_baza_id = bp.idNomBancaPartener
            inner join dbo.NomDocument nd
                on pp.idNomDocument = nd.idDocument
            left join dbo.NomBancaPartener bp2
                on pp.cont_tva_id = bp2.idNomBancaPartener
        where
            pp.programare_platas_id =" . $id;

        $detalii = DB::select($query);
        
        
        //**send user roels for javascript */
        $user = Auth::user();
        Javascript::put(['user_roles' => $user->roles()->get(),'status_pp'=>$programare->status]);

            return view('financiar.programarePlati.update')->with([
                'programare'=>$programare,
                'conturi'=>$conturi,
                'extrase'=>$extrase,
                'detalii'=>$detalii,
                'status'=>$status
                ]);
    }

    public function update(Request $request, $id)
    {
        //**Validate data */
        $this->validate($request,[
            'data'=>'required|date_format:"Y-m-d"',
            'numar'=>'required',
            'cont'=>'required',
            'startnumber'=>'required',
        ]);

        //**get ProgramareLata */
        $programarePlata = ProgramarePlata::find($id);

        //**get data from form */
        $programarePlata->data = $request->data;
        $programarePlata->cont_id = $request->cont;
        $programarePlata->extrascont_id = $request->extrasBanca;
        $programarePlata->description = $request->descriere;
        $programarePlata->startnumber = $request->startNumar;
        $programarePlata->updated_by=Auth::user()->id;


        //**save data */
        $programarePlata->save();

        //**return to list */
        $fmessage = "Modificarea a fost salavata cu succes!";
        Session::flash('success',$fmessage);

        return redirect()->route('listaprogramariplati');
    }

    public function getListeProgramari(){
        //**returns listaprogramari list */
       $query = "select distinct 
                    p.id,
                    p.number as Numar, 
                    CONVERT(char(10),p.data,126) as Data,
                    case p.status
                        when 0 then 'Initiala'
                        when 1 then 'Spre aprobare'
                        when 2 then 'Aprobata'
                        when 3 then 'Refuzata'
                        when 4 then 'Generata'
                        when 5 then 'Anulata'
                        else 'Nedefinita'
                    end as Status,
                    u.firstname + ' ' + u.lastname as Initiator,
                    u2.firstname + ' ' + u2.lastname as Aprobator,
                    p.description as Descriere,
                    ltrim(rtrim(pc.SimbolCont)) + ' - ' + ltrim(rtrim(nc.ContBanca)) as ContBancar,
                    'Extras numarul [' + convert(varchar(20),ec.Numar) + '] de la ' + convert(char(10),ec.DeLa,126) + ' pana la ' + convert(char(10),ec.PanaLa,126) as Extras
                from 
                    dbo.programare_platas p inner join dbo.users u
                        on p.created_by = u.id
                    inner join dbo.NomContBanca nc
                        on p.cont_id = nc.idNomContBanca
                    inner join dbo.NomPlanCont pc
                        on nc.idCont = pc.IdCont
                    inner join dbo.FnExtrasBanca ec
                        on p.extrascont_id = ec.idExtrasBanca
                    left join dbo.users u2
                        on p.aproved_by = u2.id
                order by p.number desc   
                                    ";

        //listaProgramari = DB::select($query);
        $listaProgramari = DB::select($query);

        //**return */
       //return response()->json(['liste'=>$listaProgramari]);
       return view('financiar.programarePlati.listaprogramari')
                ->with('listaprogramari',$listaProgramari);
    }

    protected function setNumarOp($idDetaliuProgramare,$setType){
        //** get neede values*/
        $detaliuProgramare = DetaliuProgramarePlata::find($idDetaliuProgramare);
        $idProgramare = $detaliuProgramare->programare_platas_id;
        $programare = ProgramarePlata::find($idProgramare);
        $programareNo = $programare->startnumber;
        $idPartener = $detaliuProgramare->idPartener;
        $cont_baza_id = $detaliuProgramare->cont_baza_id;

        //**get OP number*/
        $query = "select 
            max(dpp.numarOp) as numar
        from
            dbo.detaliu_programare_platas dpp
        where
            dpp.programare_platas_id = " . $idProgramare;

        $maxNo = DB::select($query);
        $maxNo = $maxNo[0]->numar;
        $no = $maxNo ? $maxNo + 1 : $programareNo;

        //** update table */
        if($setType == 'val'){
            DB::table('detaliu_programare_platas')
                ->where('programare_platas_id',$idProgramare)
                ->where('idPartener',$idPartener)
                ->where('cont_baza_id',$cont_baza_id)
                ->update(['numarOp'=>$no]);

            $opFinal = $no;
        }else{
            if($setType == 'valSingle'){
                DB::table('detaliu_programare_platas')
                ->where('id',$idDetaliuProgramare)
                ->update(['numarOp'=>$no]);

                $opFinal = $no;
            }else{
                DB::table('detaliu_programare_platas')
                ->where('id',$idDetaliuProgramare)
                ->update(['numarOp'=>null]);

                $opFinal = null;
            }

        }

        return $opFinal;

    }

    protected function getStatusProgramare($no){
        //**get status value */
        switch($no){
            case 0: $r = 'Initiala';
            break;

            case 1: $r = 'Spre aprobare';
            break;

            case 2: $r = 'Aprobata';
            break;

            case 3: $r = 'Refuzata';
            break;

            case 4: $r = 'Generata';
            break;

            case 5: $r = 'Anulata';
            break;

            case 6: $r = 'Eroare';
            break;

            default: $r = 'Nedefintia';
        };

        return $r;
    }

    //**conturi bancare && extrase*/
    
    public function getExtraseCont($id,$date){
        //**show extrasCOnt deppending on contBanca */

        //**initialise other classes */
        $utilities = new Utilities;

        //**get values for initialised classes */
        $utilities->selectedDate = $date;

        //**extrasct data */
        $anLuna = $utilities->getAnLuna();
        $contBanca = NomContBanca::find($id);
        $extraseCont = $contBanca->extraseBanca()
                                        ->where('AnLuna',$anLuna)  
                                        ->where('IdContBanca',$id)
                                        ->orderBy('Numar','DESC');  

        //**return data  */
        return response()->json(['extrase' =>$extraseCont->get(['idExtrasBanca','Numar','DeLa','PanaLa'])]);
    }

    public function getConturiBancare($id){
        //**get conturi bancare */
        
        //**select */
        $query = "select 
            bp.idNomPartener as idPartener,
            bp.idNomBancaPartener as idContBanca,
            bp.ContBanca as contBanca,
            bp.idNomBanca as idBanca,
            b.DenumireBanca as banca,
            bp.Implicita as Implicita
        from 
            dbo.NomBancaPartener bp inner join dbo.NomSucursala s
                on bp.idNomBanca = s.idNomSucursala
            inner join dbo.NomBanca b
                on s.idNomBanca = b.idNomBanca
        where
            bp.idNomPartener = " . $id;

        $banci = DB::select($query);

        //**return */
        return response()->json(['banci'=>$banci]);
    }

    //**detalii lista programari */

    public function getDetaliiListaProgramari($id){
        //**get detalii liste programari */

        $query = "select
            pp.id as id,
            pc.IdCont as idCont,
            pc.SimbolCont as simbolCont,
            np.idNomPartener as idPartener,
            ltrim(rtrim(np.DenumirePartener)) as denumirePartener,
            np.CodFiscal as codFiscal,
            bp.idNomBancaPartener as idBancaBaza,
            bp.ContBanca as contBaza,
            isnull(pp.cont_tva_id,0) as idContTVA,
            isnull(bp2.ContBanca,'')  as contTVA,
            nd.idDocument as idDocument,
            nd.Cod as tipDocument,
            pp.numarDocument as numarDocument,
            convert(char(10),pp.dataDocument,126) as dataDocument,
            convert(char(10),pp.dataScadenta,126) as dataScadenta,
            pp.zileDepasite as zileDepasite,
            pp.sold as sold,
            case pp.splitTva
                when 0  then 'nu'
                when 1  then 'da'
                when 3  then 'none'
                else 'null'
            end as splitTVA,
            pp.plataTotal as plataTotal,
            pp.plataBaza as plataBaza,
            pp.plataTva as plataTVA,
            pp.numarOp,
            pp.status,
            case pp.status
                when 0 then 'Initiala'
                when 1 then 'Generata'
                when 2 then 'Eroare'
                when 3 then 'Extra modul'
            end as statusVal,
            bp.Implicita
        from
            dbo.detaliu_programare_platas pp inner join dbo.NomPlanCont pc
                on pp.idContContabil = pc.IdCont
            inner join dbo.NomPartener np
                on np.idNomPartener = pp.idPartener
            inner join dbo.NomBancaPartener bp
                on pp.cont_baza_id = bp.idNomBancaPartener
            inner join dbo.NomDocument nd
                on pp.idNomDocument = nd.idDocument
            left join dbo.NomBancaPartener bp2
                on pp.cont_tva_id = bp2.idNomBancaPartener
        where
            pp.programare_platas_id =" . $id;

        $detalii = DB::select($query);

        //**return */
        return response()->json(['detalii'=>$detalii]);
    }

    public function getDetaliuListaProgramari($id){
        //**get detaliu liste programari */

        $query = "select top 1
            pp.id as id,
            pc.IdCont as idCont,
            pc.SimbolCont as simbolCont,
            np.idNomPartener as idPartener,
            ltrim(rtrim(np.DenumirePartener)) as denumirePartener,
            np.CodFiscal as codFiscal,
            bp.idNomBancaPartener as idBancaBaza,
            bp.ContBanca as contBaza,
            isnull(pp.cont_tva_id,0) as idContTVA,
            isnull(bp2.ContBanca,'')  as contTVA,
            nd.idDocument as idDocument,
            nd.Cod as tipDocument,
            pp.numarDocument as numarDocument,
            convert(char(10),pp.dataDocument,126) as dataDocument,
            convert(char(10),pp.dataScadenta,126) as dataScadenta,
            pp.zileDepasite as zileDepasite,
            pp.sold as sold,
            case pp.splitTva
                when 0  then 'nu'
                when 1  then 'da'
                when 3  then 'none'
                else 'null'
            end as splitTVA,
            pp.plataTotal as plataTotal,
            pp.plataBaza as plataBaza,
            pp.plataTva as plataTVA,
            pp.numarOp,
            pp.status,
            case pp.status
                when 0 then 'Initiala'
                when 1 then 'Generata'
                when 2 then 'Eroare'
                when 3 then 'Extra modul'
            end as statusVal,
            bp.Implicita
        from
            dbo.detaliu_programare_platas pp inner join dbo.NomPlanCont pc
                on pp.idContContabil = pc.IdCont
            inner join dbo.NomPartener np
                on np.idNomPartener = pp.idPartener
            inner join dbo.NomBancaPartener bp
                on pp.cont_baza_id = bp.idNomBancaPartener
            inner join dbo.NomDocument nd
                on pp.idNomDocument = nd.idDocument
            left join dbo.NomBancaPartener bp2
                on pp.cont_tva_id = bp2.idNomBancaPartener
        where
            pp.id =" . $id;

        $detaliu = DB::select($query);

        //**return */
        return response()->json(['detaliu' => $detaliu]);

    }

    protected function insertProgramarePlata($sold,$programare_platas_id,$type){
        //**insert new entry in  detaliu_programare_plata_s*/

        //**get values for new entry */
        $idContContabil = $sold->IdCont;
        $idNomDocument = $sold->IdNomDocument;
        $numarDocument = $sold->NumarDocument;
        $dataDocument = $sold->DataDocument;
        $idPartener = $sold->IdPartener;
        $dataScadenta = $sold->DataScadenta;
        $zileDepasite = $sold->zileDepasite;
        $idAdresaEx = $sold->idAdresaEx;
        $tvaLaIncasare = $sold->TVALaIncasare;
        $soldFinal = $sold->SoldFinal;
        $cont_baza_id = $sold->idContBazaImplicit;
        $cont_tva_id = 0;
        $plataTotal = 0;
        $plataBaza = 0;
        $plataTva = 0;
        $created_by = Auth::user()->id;
        $updated_by = Auth::user()->id;

        if($type == 'initial'){
            $detaliuProgramarePlata = DetaliuProgramarePlata::create([
                'programare_platas_id'=>$programare_platas_id,
                'idContContabil'=>$idContContabil,
                'idNomDocument'=>$idNomDocument,
                'numarDocument'=>$numarDocument,
                'dataDocument'=>$dataDocument,
                'idPartener'=>$idPartener,
                'dataScadenta'=>$dataScadenta,
                'zileDepasite'=>$zileDepasite,
                'idAdresaEx'=>$idAdresaEx,
                'tvaLaIncasare'=>$tvaLaIncasare,
                'sold'=>$soldFinal,
                'cont_baza_id'=>$cont_baza_id,
                'cont_tva_id'=>$cont_tva_id,
                'plataTotal'=>$plataTotal,
                'plataBaza'=>$plataBaza,
                'plataTva'=>$plataTva,
                'created_by'=>$created_by,
                'updated_by'=>$updated_by,
                'status'=>0
            ]);
            }else{
                $ckRecord = DB::table('detaliu_programare_platas')
                    ->where('idContContabil',$idContContabil)
                    ->where('idNomDocument',$idNomDocument)
                    ->where('numarDocument',$numarDocument)
                    ->where('idPartener',$idPartener)
                    ->where('idAdresaEx',$idAdresaEx)
                    ->where('sold',$soldFinal)
                    ->where('programare_platas_id',$programare_platas_id)
                    ->where('plataTotal','!=','0')
                    ->exists();
                if($ckRecord != 1){
                    $detaliuProgramarePlata = DetaliuProgramarePlata::create([
                        'programare_platas_id'=>$programare_platas_id,
                        'idContContabil'=>$idContContabil,
                        'idNomDocument'=>$idNomDocument,
                        'numarDocument'=>$numarDocument,
                        'dataDocument'=>$dataDocument,
                        'idPartener'=>$idPartener,
                        'dataScadenta'=>$dataScadenta,
                        'zileDepasite'=>$zileDepasite,
                        'idAdresaEx'=>$idAdresaEx,
                        'tvaLaIncasare'=>$tvaLaIncasare,
                        'sold'=>$soldFinal,
                        'cont_baza_id'=>$cont_baza_id,
                        'cont_tva_id'=>$cont_tva_id,
                        'plataTotal'=>$plataTotal,
                        'plataBaza'=>$plataBaza,
                        'plataTva'=>$plataTva,
                        'created_by'=>$created_by,
                        'updated_by'=>$updated_by,
                        'status'=>0
                    ]);
                }   
            }
    }

    protected function createDetaliiProgramarePlata($programare_platas_id,$type){
        //**add entries to detaliu_porogramare_platas */

        //**initialise other classes/objects */
        $utilities = new Utilities;
        $programarePlata = ProgramarePlata::find($programare_platas_id);

        //**get values for initialised classes */
        $dataMaster = $programarePlata->data;

        //**get variables for sql procedure */
        $DataStart = $utilities->getDateInfo($dataMaster,'ymd');
        $LunaStart = $utilities->getDateInfo($dataMaster,'m');
        $DataStop = $DataStart;
        $LunaStop = $LunaStart;
        $An = $utilities->getDateInfo($dataMaster,'y');
        $TabCont = implode("','",$this->idsConturiParteneri);
        $AnLunaCur = $utilities->getDateInfo($dataMaster,'ym');
        
        //**get solduri & insert details*/
        $query = "SET NOCOUNT ON; {call rapFisaPartenerSoldFacturiTotiPartenerii_ah_pp (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        
        $solduri = DB::select($query,array(
                        1                   //idPunctLucru	= 1
                        ,$DataStart         //DataStart
                        ,$LunaStart         //LunaStart
                        ,2                  //TipStart	    = 2
                        ,$DataStop          //DataStop
                        ,$LunaStop          //LunaStop	
                        ,200                //TipStop       = 200
                        ,$An                //An	
                        ,0                  //Flag          = 0
                        ,'-'                //TabPart	    = '-'
                        ,$TabCont           //TabCont
                        ,$AnLunaCur         //AnLunaCur 
                        ,0                  //Sintetic      = 0
                        ,0                  //CuDiscount    = 0
                        ,'19000101'         //DataPanaLa    = '19000101'
                        ,'-'                //TabDepartament='-'
                    ));

        foreach ($solduri as $sold){
            $this->insertProgramarePlata($sold,$programare_platas_id,$type);
        }   
        
    }

    public function updateDetaliu(Request $request, $id){
        //**get detaliuProgramarePlata */
        $detaliu = DetaliuProgramarePlata::find($id);
        $splitTva = $request->splitTva;

        $rules=array(
            'cont_baza_id'=>'required|min:1',
            'plataTotal'=>'numeric',
            'plataBaza'=>'numeric',
        );

        if($splitTva == 'da'){
            $rules['cont_tva_id'] = 'required|min:1';
        }


        $validator = Validator::make(input::all(),$rules);
        if($validator->fails()){
            return response()->json(array('errors'=>$validator->getMessageBag()->toarray()));
        }else{
            //**get values */        
            $detaliu->cont_baza_id = $request->cont_baza_id;
            $detaliu->cont_tva_id = $request->cont_tva_id;
            $detaliu->plataTotal = $request->plataTotal;
            $detaliu->plataBaza = $request->plataBaza;
            $detaliu->plataTva = $request->plataTva;
            $detaliu->updated_by = Auth::user()->id;
            $detaliu->save();

            $val = $request->plataBaza;
            $numarOp = $request->numarOp;
           // $numarOp = 

            if(!$numarOp || $numarOp == '' || $numarOp == 0){
                if($val != 0){
                    $numarOpR = $this->setNumarOp($id,'val');
                }else{
                    $numarOpR = $this->setNumarOp($id,'noval');
                }
            }else{
                if($val == 0){
                    $numarOpR = $this->setNumarOp($id,'noval');
                }else{
                    $ckOp = DB::table('detaliu_programare_platas')
                        ->where('programare_platas_id',$detaliu->programare_platas_id)
                        ->where('idPartener',$detaliu->idPartener)
                        ->where('cont_baza_id',$detaliu->cont_baza_id)
                        ->where('id','!=',$id)
                        ->whereNotNull('numarOp')
                        ->count();
                    if($ckOp > 0){
                        $numarOpR = $numarOp;
                    }else{
                        $numarOpR = $this->setNumarOp($id,'valSingle');
                    }
                }
            }
            //** update numar OP */
           // $this->setNumarOp($id,$setType);

            //**update cont implicit */
            $setContImplicit = $request->setContImplicit;
            $idNomPartener = $request->idNomPartener;
            $idNomBancaPartener = $request->cont_baza_id;
            
            if($setContImplicit == 1 && $idNomBancaPartener != 0 && $idNomBancaPartener != ''){   
               DB::table('dbo.NomBancaPartener')
                    ->where('idNomPartener',$idNomPartener)
                    ->update(['Implicita'=>0]);
               DB::table('dbo.NomBancaPartener')
                    ->where('idNomBancaPartener',$idNomBancaPartener)
                    ->update(['Implicita'=>1]);
               $idProgramare = DetaliuProgramarePlata::find($id)->programare_platas_id;
                
               DB::table('dbo.detaliu_programare_platas')
                    ->where('programare_platas_id',$idProgramare)
                    ->where('idPartener',$idNomPartener)
                    ->where('cont_baza_id',0)
                    ->update(['cont_baza_id'=>$idNomBancaPartener]);
                }
             
            return response()->json(['numarop'=>$numarOpR]);
        }
    }

    public function deleteDetaliu($id){
        //**get detaliuProgramarePlata */
        $detaliu = DetaliuProgramarePlata::find($id);
        $detaliu->delete();

    }

    protected function getStatusDetaliuProgramare($no){
        //**get status value */
        switch($no){
            case 0: $r = 'Initiala';
            break;

            case 1: $r = 'Generata';
            break;

            case 2: $r = 'Eroare';
            break;


            default: $r = 'Nedefintia';
        };

        return $r;
    }

    public function updateNumarOpSpot(Request $request, $id){
        //**update numaprOp SPOT */
        DB::table('detaliu_programare_platas')
            ->where('id',$id)
            ->update(['numarOp'=>$request->numarOp]);
        
            return response()->json(['numarop'=>$request->numarOp]);
    }

    public function updateDetaliiProgramarePlata($idProgramarePlata){
        //** update detaliu_programare_platas*/

        //**delete records wo payments */
        DB::table('detaliu_programare_platas')
            ->where('programare_platas_id',$idProgramarePlata)
            ->where('plataTotal',0)
            ->delete();

        //**update list */
        $this->createDetaliiProgramarePlata($idProgramarePlata,'update');

        //**update date anaf */
        UpdateAnafData::insertAnafData($idProgramarePlata);
        
        //**update splitTVA in detaliiProgramarePlata */
        UpdateAnafData::updateDetaliiPpSplit($idProgramarePlata);
        
        //**return */
        $fmessage = "Actualizarea listei s-a efectuat cu succes cu succes!";
        Session::flash('success',$fmessage);

        //**return */
        return redirect()->back();
    }

    public function getBazaTvaData(Request $request){
        $idPartener     = $request->idPartener;
        $idNomDocument  = $request->idNomDocument;
        $numarDocument  = $request->numarDocument;
        $dataDocument   = $request->dataDocument;

        $info = GetDocumentsInfo::getBazaTvaValues($idPartener,$idNomDocument,$numarDocument,$dataDocument);
        if($info != 'nodata'){
            $baza = $info['baza'];
            $tva = $info['tva'];
        }else{
            $baza = 0;
            $tva = 0;
        }

        $result['baza'] = $baza;
        $result['tva'] = $tva;

        return response()->json(['bazatva'=>$result]);
    }

    //**approval flow */

    public function trimiteSpreAprobare($id){
        $programarePlata = ProgramarePlata::find($id);
        $programarePlata->status = 1;
        $programarePlata->update();

        //**return */
        $fmessage = "Programarea a fost trimisa spre aprobare!";
        Session::flash('success',$fmessage);

        return redirect()->route('showUpdateListaPp',['id'=>$id]);
    }

    public function aproba($id){
        $programarePlata = ProgramarePlata::find($id);
        $programarePlata->status = 2;
        $programarePlata->aproved_by = Auth::user()->id;
        $programarePlata->aproved_at = date('Y-m-d H:i:s');
        $programarePlata->update();

        //**return */
        $fmessage = "Programarea a fost aprobata!";
        Session::flash('success',$fmessage);

        return redirect()->route('showUpdateListaPp',['id'=>$id]);
    }

    public function respinge($id){
        $programarePlata = ProgramarePlata::find($id);
        $programarePlata->status = 3;
        $programarePlata->aproved_by = Auth::user()->id;
        $programarePlata->aproved_at = date('Y-m-d H:i:s');
        $programarePlata->update();

        //**return */
        $fmessage = "Programarea a fost respinsa!";
        Session::flash('success',$fmessage);

        return redirect()->route('showUpdateListaPp',['id'=>$id]);
    }

    public function reanaliza($id){
        $programarePlata = ProgramarePlata::find($id);
        $programarePlata->status = 0;
        $programarePlata->aproved_by = Auth::user()->id;
        $programarePlata->aproved_at = date('Y-m-d H:i:s');
        $programarePlata->update();

        //**return */
        $fmessage = "Programarea a fost trimisa spre reanaliza!";
        Session::flash('success',$fmessage);

        return redirect()->route('showUpdateListaPp',['id'=>$id]);
    }

    //**generate transactions in Synchron */
    public function genereazaPlati($id){
        //**generate payments transactions in ERP database */

        //**get user id */
        $idUser = Auth::user()->id;

        //**define query */
        $query = "SET NOCOUNT ON; {call bks_genereazaPlatiBanca (?,?)}";

        //**call sql procedure */
        $go = DB::select($query,array($id,$idUser));

        //**return */
        $fmessage = "Generarea tranzactiilor a fost efectuata cu succes!";
        Session::flash('success',$fmessage);

        return redirect()->route('showUpdateListaPp',['id'=>$id]);

    }


}
