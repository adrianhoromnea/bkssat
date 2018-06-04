<!-- **programarePlataDetails - others-->
<div class="container-fluid" hidden id="listaManual">
    
    <div class="card">
        <div class="card-body">
            <div class="row breadcrumb" style="background:#F0F0F0">   
                    <div class="col-1">
                        <strong>Lista plati suplimentare</strong>
                    </div>

                    <div class="col-10 justify-content-center">
                        <div class="form-inline justify-content-center" id="pm_form" hidden>
                            <input name="pm_op" id="pm_op" class="form-control mr-2 w-5" placeholder="...op">
                            <input type="text" name="pm_partener" id="pm_partener" placeholder="...partener" class="form-control mr-2 w-25">
                            <input name="pm_explicatii" id="pm_explicatii" class="form-control mr-2 w-25" placeholder="...explicatii">
                            <input type="number" name="pm_valoare" step="0.01" id="pm_valoare" placeholder="... valoare" class="form-control mr-2 w-10">
                            <div class="form-group float-right">
                                <button class="btn btn-success mr-2" name="pm_salveaza" id="pm_salveaza">Salveaza</button>
                                <button class="btn btn-outline-secondary mr-2" name="pm_renunta" id="pm_renunta">Renunta</button>
                            </div>  
                        </div>
                        <!--
                        <div class="form-inline justify-content-center" id="pm_total">
                            <input type="text" class="form-control mr-2" id="pm_cauta" placeholder="Cauta ...">
                            <a href="#"><i class="fa fa-building mr-5" id="pm_gosubtotal"  data-toogle="tooltip" title="Subtotal"></i></a>
                            <label class="mr-2" for="pm_plata_total">Plata:</label>&nbsp; &nbsp; &nbsp;
                            <input type="text" class="form-control mr-2" id="pm_plata_total" name="pm_plata_total" readonly>
                        </div>
                        -->
                    </div>

                    <div class="col-1">
                        @if(auth()->user()->hasAnyRole(['Financiar']) AND $programare->status == 0)
                        <div class="float-right">
                            <a href="#">
                                <input type="button" class="btn btn-success" value="+" title="Adauga plata noua" data-toogle="tooltip" id="pm_addNew">
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
                            <th><div>Detalii</div></th>
                            <th><div>Plata total</div></th>
                            <th hidden><div>Ver</div></th>
                            <th><div>...</div></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detaliialtele as $detaliualtele)
                            <tr>
                                <td hidden value="{{$detaliualtele->id}}">{{$detaliualtele->id}}</td>
                                <td width:50px style="max-width: 100px">{{$detaliualtele->numarOp}}</td>
                                <td style="max-width: 150px">{{$detaliualtele->partener}}</td>
                                <td style="max-width: 300px">{{$detaliualtele->descriere}}</td>
                                <td style="max-width: 25px" class="pm_plata">{{$detaliualtele->valoare}}</td>
                                <td hidden>{{$detaliualtele->verificare}}</td>
                                <td  style="min-width: 30px"><a href="#" style="color:red; text-decoration:none"><i class="fa fa-trash-o" title="Sterge linie" data-toogle="tooltip" id="btnDeleteRow2"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>  
        </div>
    </div>
</div>


