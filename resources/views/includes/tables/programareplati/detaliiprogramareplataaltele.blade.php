<!-- **programarePlataDetails - others-->
<div class="container-fluid" hidden id="listaManual">
    
    <div class="card">
        <div class="card-body">
            <div class="row breadcrumb" style="background:#F0F0F0">   
                <div class="col-2">
                    <strong>Lista plati suplimentare</strong>
                </div>
                @php
    $jsPpPlatiSuplimentare = "set";
@endphp
                <div class="col-8 justify-content-center">
                    @include('includes.forms.financiar.programareplati.formadddetaliumanual')
                    @include('includes.forms.financiar.programareplati.formadddetaliumanual1')
                </div>
                <div class="col-2">
                    @if(auth()->user()->hasAnyRole(['Financiar']) AND $programare->status == 0)
                    <div class="float-right">
                        <a href="#">
                            <input type="button" class="btn btn-success" value="+ non F" title="Adauga plata noua - NON-furnizor" data-toogle="tooltip" id="pm_addNew">
                            <input type="button" class="btn btn-success" value="+ F" title="Adauga plata noua - Furnizor" data-toogle="tooltip" id="pm_addNew_f">
                        </a>
                    </div>
                    @endif
                </div>
                    
            </div>
        </div>
    </div>
   
    <div class="card">
        <div class="card-body">
            <div class="table-container double-scroll">
                <table class="table sortable table-bordered table-hover tablefixed" id="dataTable2" cellspacing="0" data-toggle="table">
                    <thead>
                        <tr>
                            <th hidden><div>id</div></th>
                            <th style="max-width:50px"><div>OP</div></th>
                            <th><div>Partener</div></th>
                            <th><div>Cont bancar</div></th>
                            <th><div>Detalii</div></th>
                            <th><div>Plata total</div></th>
                            <th><div>Ver</div></th>
                            <th><div>...</div></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detaliialtele as $detaliualtele)
                            <tr>
                                <td hidden rowId="{{$detaliualtele->id}}">{{$detaliualtele->id}}</td>
                                <td width:50px style="max-width: 100px">{{$detaliualtele->numarOp}}</td>
                                <td style="max-width: 150px">{{$detaliualtele->partener}}</td>
                                <td width:50px style="max-width: 100px" class="cont">{{$detaliualtele->cont}}</td>
                                <td style="max-width: 300px">{{$detaliualtele->descriere}}</td>
                                <td style="max-width: 25px" class="pm_plata" valoare = "{{$detaliualtele->valoare}}">{{$detaliualtele->valoare}}</td>
                                <td style="text-align: center" class="ck1">
                                    <div class="checkbox-inline justify-content-center align-items-center">
                                        <input type="checkbox" name="check" value="{{$detaliualtele->verificare}}" class="ckline1" {{$detaliualtele->verificare == 1 ? 'checked' : ''}}>
                                    </div>
                                </td>
                                <td  style="min-width: 30px"><a href="#" style="color:red; text-decoration:none"><i class="fa fa-trash-o" title="Sterge linie" data-toogle="tooltip" id="btnDeleteRow2"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>  
        </div>
    </div>
</div>


