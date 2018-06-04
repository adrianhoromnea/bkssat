<!-- **programarePlataDetails-->

<!--  define  variable for including js scripts for tables-->
@php
    $jsTables = "set";
@endphp

<div class="container-fluid" id="listaSistem">
    <div class="card">
      <!--
        <div class="card-body">
          <div class="row breadcrumb" style="background:#F0F0F0">
            <div class="col">
              <input type="text" id = "inputSearch" style="text-align:left" placeholder="Cauta ...">
              &nbsp; &nbsp;<a href="#"><i class="fa fa-building" id="goSubtotal"  data-toogle="tooltip" title="Subtotal"></i></a>
            </div>
            
            <div class="col">
              Sold: &nbsp;<input type="text" readonly id = "stSold" style="text-align:center">&nbsp; &nbsp; &nbsp;
            </div>
            <div class="col">
              Total plati: &nbsp;<input type="text" readonly id = "stPlataTotal" style="text-align:center">&nbsp; &nbsp; &nbsp;
            </div>
            <div class="col">
              Plata baza: &nbsp;<input type="text" readonly id = "stPlataBaza" style="text-align:center">&nbsp; &nbsp; &nbsp;
            </div>
            <div class="col">
              Plata TVA: &nbsp;<input type="text" readonly id = "stPlataTva" style="text-align:center">&nbsp; &nbsp; &nbsp;
            </div>
          </div>
        </div>
      -->
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
                        <td class="sSold ">{{$detaliu->sold}}</td>
                        <td class="" style="min-width: 50px">{{$detaliu->splitTVA}}</td>
                        <td class="sTotal "style="min-width: 120px">{{$detaliu->plataTotal}}</td>
                        <td class="sBaza " style="min-width: 120px;cursor:pointer">{{$detaliu->plataBaza}}</td>
                        <td class="sTva " style="min-width: 120px" >{{$detaliu->plataTVA}}</td>
                        <td class="" >{{$detaliu->statusVal}}</td>
                        <td  style="min-width: 30px"><a href="#" style="color:red; text-decoration:none"><i class="fa fa-trash-o" title="Sterge linie" data-toogle="tooltip" id="btnDeleteRow"></i></a></td>
                    </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>
    </div>
</div>
