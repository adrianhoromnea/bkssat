<!-- Modal for creating a new extrasCont  -->
<input type="text" hidden value="" id="idModalRow">
<input type="text" hidden value="" id="m_idPartener">
<div id="detaliuprogramareplataUpdateModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modifica plata</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <p id="m_parCont"></p>
                        <p id="m_parPartener"></p>
                        <p id="m_parTip">Tip: </p>
                        <p id="m_parNumar">Numar: </p>
                    </div>
                    <div class="col">
                        <p id="m_parData">Data: </p>
                        <p id="m_parScadenta">Scadenta: </p>
                        <p id="m_parZile">Zile depasire: </p>
                        <p id="m_op" valoare = "">OP: </p>
                    </div>
                </div>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST">
                {{ csrf_field() }}
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="m_contBaza">Cont baza*:</label>
                                <select class="form-control" name="m_contBaza" id="m_contBaza" required>
                                        <option value="" selected disabled >Selecteaza contul bancar - baza</option>                                    
                                </select>
                                <span class="help-block text-danger">
                                    <strong id="m_errorContBaza"></strong>
                                </span>
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label><input type="checkbox" value="" id="m_ckImplicit"> Implicit</label>
                                </div>

                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="m_contTva">Cont TVA:</label>
                                <select class="form-control" name="m_contTva" id="m_contTva">
                                        <option value="" selected disabled >Selecteaza contul bancar - TVA</option>                                    
                                </select>
                                <span class="help-block text-danger">
                                    <strong id="m_errorContTva"></strong>
                                </span>
                            </div>
                            <div class="form-group">
                                <span>Split TVA: &nbsp;&nbsp;</span><span id="m_splitTva"></span>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="m_sold">Sold document:</label>
                                <input type="text" class="form-control" id="m_sold" autofocus name="m_sold" readonly>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="m_plataTotal">Plata total:</label>
                                <input type="text" class="form-control" id="m_plataTotal" autofocus name="m_plataTotal" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="m_plataBaza">Plata baza:</label>
                                <input type="number" class="form-control allFocus" id="m_plataBaza" autofocus name="m_plataBaza" step=".01">
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="m_plataTva">Plata TVA:</label>
                                <input type="number" class="form-control allFocus" id="m_plataTva" autofocus name="m_plataTva" step=".01" disabled>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">
                        Renunta
                    </button>

                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="m_btnSalveaza">
                        Salveaza
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>