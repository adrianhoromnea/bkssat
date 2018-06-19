<!-- **programarePlataDetails-->

<!--  define  variable for including js scripts for tables-->
@php
    $jsTables = "set";
@endphp

<div class="container-fluid" id="listaSistem">
    <div class="card">
        <div class="card-body pt-5">
          <div class="table-container double-scroll">
            <table class="table sortable table-bordered table-hover tablefixed" id="dataTable1" cellspacing="0" data-toggle="table">
              <thead>
                <tr style="cursor:pointer">
                  <th hidden><div></div></th>
                  <th class="" ><div>OP</div></th>
                  <th class=""><div>Cont</div></th>
                  <th ><div>Partener</div></th>
                  <th class=""><div>CUI</div></th>
                  <th class=""><div>Cont Baza</div></th>
                  <th class=""><div>Cont TVA</div></th>
                  <th class=""><div>Tip</div></th>
                  <th class=""><div>Numar</div></th>
                  <th class=""><div>Data</div></th>
                  <th class=""><div>Scadenta</div></th>
                  <th class=""><div>Zi</div></th>
                  <th class=""><div>Sold</div></th>
                  <th class="" ><div>Split</div></th>
                  <th class=""><div>Plata total</div></th>
                  <th class="" ><div>Plata baza</div></th>
                  <th class=""><div>Plata TVA</div></th>
                  <th class=""><div>Status</div></th>
                  <th class=""><div>Ver</div></th>
                  <th><div>...</div></th>
                </tr>
              </thead>
              <tbody>
                  @foreach($detalii as $detaliu)
                    <tr>
                        <td hidden id="{{$detaliu->id}}" rowId="{{$detaliu->id}}"></td>
                        <td  width:100px class="" style="min-width: 50px;cursor:pointer">{{$detaliu->numarOp}}</td>
                        <td  width:100px class="" id="{{$detaliu->idCont}}">{{$detaliu->simbolCont}}</td>
                        <td  class="" id="{{$detaliu->idPartener}}" style="max-width: 240px">{{$detaliu->denumirePartener}}</td>
                        <td class="" style="max-width: 120px">{{$detaliu->codFiscal}}</td>
                        <td  class="" id="{{$detaliu->idBancaBaza}}" style="max-width: 240px; min-width: 240px">{{$detaliu->contBaza}}</td>
                        <td  class="" id="{{$detaliu->idContTVA}}" style="max-width: 240px; min-width: 240px">{{$detaliu->contTVA}}</td>
                        <td  class="" id="{{$detaliu->idDocument}}">{{$detaliu->tipDocument}}</td>
                        <td class="" style="max-width: 100px">{{$detaliu->numarDocument}}</td>
                        <td class="" >{{$detaliu->dataDocument}}</td>
                        <td class="" >{{$detaliu->dataScadenta}}</td>
                        <td class="">{{$detaliu->zileDepasite}}</td>
                        <td class="sSold " valoare = "{{$detaliu->sold}}">{{$detaliu->sold}}</td>
                        <td class="" style="min-width: 50px">{{$detaliu->splitTVA}}</td>
                        <td class="sTotal "style="min-width: 120px" valoare = "{{$detaliu->plataTotal}}">{{$detaliu->plataTotal}}</td>
                        <td class="sBaza " style="min-width: 120px;cursor:pointer" valoare = "{{$detaliu->plataBaza}}">{{$detaliu->plataBaza}}</td>
                        <td class="sTva " style="min-width: 120px" valoare = "{{$detaliu->plataTVA}}">{{$detaliu->plataTVA}}</td>
                        <td class="" >{{$detaliu->statusVal}}</td>
                        <td style="text-align: center" class="ck">
                          <div class="checkbox-inline justify-content-center align-items-center">
                            <input type="checkbox" name="check" value="{{$detaliu->checked}}" class="ckline" {{$detaliu->checked == 1 ? 'checked' : ''}}>
                          </div>
                        </td>
                        <td  style="min-width: 30px"><a href="#" style="color:red; text-decoration:none"><i class="fa fa-trash-o" title="Sterge linie" data-toogle="tooltip" id="btnDeleteRow"></i></a></td>
                    </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>
    </div>
</div>
