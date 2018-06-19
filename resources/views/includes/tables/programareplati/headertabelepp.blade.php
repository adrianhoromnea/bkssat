<!--  define  variable for including js scripts for tables-->
@php
    $jsTables = "set";
@endphp

<!-- **programarePlataDetails - others-->
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row breadcrumb" style="background:#F0F0F0">   
                    <div class="col-2 justify-content-center align-items-center">
                        <div class="input-group align-items-center pb-3" id="d_inputSearch">
                            <input type="text" class="form-control form-control-sm mr-2" id="inputSearch" placeholder="Cauta ...">
                            <a href="#"><i class="fa fa-building" id="goSubtotal"  data-toogle="tooltip" title="Subtotal"></i></a>
                        </div>
                        <div class="input-group align-items-center pb-3" id="d_inputSearch2" hidden>
                            <input type="text" class="form-control form-control-sm mr-2" id="inputSearch2" placeholder="Cauta ...">
                            <a href="#"><i class="fa fa-building" id="pm_gosubtotal"  data-toogle="tooltip" title="Subtotal"></i></a>
                        </div>
                        <div class="input-group align-items-center btn btn-outline-info btn-sm"><br>
                            <span>Ver. sist:</span> &nbsp;
                            <span id = "cck"></span>&nbsp;<span>linii /</span>&nbsp;
                            <span id = "cckv"></span>&nbsp;<span>ron</span>
                        </div>
                        <div class="input-group align-items-center btn btn-outline-info btn-sm"><br>
                            <span>Ver. manual:</span> &nbsp;
                            <span id = "cck1"></span>&nbsp;<span>linii /</span>&nbsp;
                            <span id = "cckv1"></span>&nbsp;<span>ron</span>
                        </div>
                    </div>

                    <div class="col-2 justify-content-center align-items-center">
                        <div class="input-group align-items-center pb-3">
                            <span class="input-group-addon mr-1">Sold</span>
                            <input type="text" readonly id = "stSold" style="text-align:center" name ="stSold" class="form-control form-control-sm" valoare="0.00">
                        </div>
                        <div class="input-group align-items-center btn btn-outline-secondary btn-sm"><br>
                            <span>CSV:</span> &nbsp;
                            <span id = "csv" valoare="0.00"></span>&nbsp;<span>ron</span>
                        </div>
                    </div>

                    <div class="col-3 justify-content-center align-items-center">
                        <div class="input-group align-items-center justify-content-right" >
                            <span class="input-group-addon mr-1">T.Sist &nbsp;</span>
                            <input type="text" readonly id = "stPlataTotal" style="text-align:center" name ="stSold" class="form-control form-control-sm" valoare="0.00">
                        </div>
                        <div class="input-group align-items-center justify-content-right">
                            <span class="input-group-addon mr-1">T.Man</span>
                            <input type="text" readonly id = "pm_plata_total" style="text-align:center" name ="stSold" class="form-control form-control-sm" valoare="0.00">
                        </div>
                        <div class="input-group align-items-center justify-content-right">
                            <span class="input-group-addon mr-1">Total &nbsp;</span>
                            <input type="text" readonly id = "grand_total" style="text-align:center" name ="stSold" class="form-control form-control-sm" valoare="0.00">
                        </div>
                    </div>

                    <div class="col-3 justify-content-center align-items-center">
                        <div class="input-group align-items-center justify-content-right" >
                            <span class="input-group-addon mr-1">Baza.Sist &nbsp;</span>
                            <input type="text" readonly id = "stPlataBaza" style="text-align:center" name ="stSold" class="form-control form-control-sm" valoare="0.00">
                        </div>
                        <div class="input-group align-items-center justify-content-right">
                            <span class="input-group-addon mr-1">Baza.Man</span>
                            <input type="text" readonly id = "pm_plata_baza" style="text-align:center" name ="stSold" class="form-control form-control-sm" valoare="0.00">
                        </div>
                        <div class="input-group align-items-center justify-content-right">
                            <span class="input-group-addon mr-1">Total &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <input type="text" readonly id = "grand_total_baza" style="text-align:center" name ="stSold" class="form-control form-control-sm" valoare="0.00">
                        </div>
                    </div>
                        
                    <div class="col-2 justify-content-center align-items-center">
                        <div class="input-group align-items-center justify-content-right" >
                            <span class="input-group-addon mr-1">Tva.Sist &nbsp;</span>
                            <input type="text" readonly id = "stPlataTva" style="text-align:center" name ="stSold" class="form-control form-control-sm" valoare="0.00">
                        </div>
                        <div class="input-group align-items-center justify-content-right">
                            <span class="input-group-addon mr-1">Tva.Man</span>
                            <input type="text" readonly id = "pm_plata_tva" style="text-align:center" name ="stSold" class="form-control form-control-sm" valoare="0.00">
                        </div>
                        <div class="input-group align-items-center justify-content-right">
                            <span class="input-group-addon mr-1">Total &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <input type="text" readonly id = "grand_total_tva" style="text-align:center" name ="stSold" class="form-control form-control-sm" valoare="0.00">
                        </div>
                    </div>
            </div>
        </div>
    </div>