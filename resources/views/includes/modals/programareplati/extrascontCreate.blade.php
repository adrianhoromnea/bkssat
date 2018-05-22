<!-- Modal for creating a new extrasCont  -->

<div id="createExtrasModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adauga extras cont</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST">
                {{ csrf_field() }}
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="numarExtras">Numar*:</label>
                                <input type="text" class="form-control" id="numarExtras" autofocus name="numarExtras" required>
                                <span class="help-block text-danger">
                                    <strong id="errorNumar"></strong>
                                </span>
                            </div>
                        </div>

                         <div class="col">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="dataExtras">Data*:</label>
                                <input type="text" class="form-control datePickerRestrTomorrow" id="dataExtras" autofocus name="dataExtras" readonly required>
                                <span class="help-block text-danger">
                                    <strong id="errorData"></strong>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="deLaExtras">De_la*:</label>
                                <input type="text" class="form-control datePickerRestrTomorrow" id="deLaExtras" autofocus name="deLaExtras" readonly required>
                                <span class="help-block text-danger">
                                    <strong id="errorDeLa"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="panaLaExtras">Pana_la*:</label>
                                <input type="text" class="form-control datePickerRestrTomorrow" id="panaLaExtras" autofocus name="panaLaExtras" readonly required>
                                <span class="help-block text-danger">
                                    <strong id="errorPanaLa"></strong>
                                </span>
                            </div>
                        </div>  
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="observatie">Observatie:</label>
                        <div class="col-md-20">
                            <textarea class="form-control" id="observatieExtras" cols="40" rows="5" name="observatieExtras"></textarea>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">
                        Renunta
                    </button>

                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnAddExtras">
                        Adauga
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>