<!--- FORM add detaliprogramareplata Furnizor -->


<div id="pm_form1" hidden>
    <div class="form-group pb-2">
        <input name="pm_op1" id="pm_op1" class="form-control mr-2 w-25" placeholder="...op">
    </div>
    <div class="form-group pb-2">
        <select id="pm_partener1" class="form-control mr-2 w-25">
            <option value="" selected disabled>Selecteaza partenerul ...</option>
        </select>
    </div>
    <div class="form-group pb-2">
        <select id="pm_contbancar" class="form-control mr-2 w-25">
            <option value="" selected disabled>Selecteaza contul bancar ...</option>
        </select>
    </div>
    <div class="form-group pb-2">
            <input name="pm_explicatii1" id="pm_explicatii1" class="form-control mr-2 w-50" placeholder="...explicatii">
    </div>
    <div class="form-group pb-2">
        <input type="number" name="pm_valoare1" step="0.01" id="pm_valoare1" placeholder="... valoare" class="form-control mr-2 w-25">
    </div>
    <div class="form-group justify-content-center float-right">
            <button class="btn btn-success mr-2" name="pm_salveaza1" id="pm_salveaza1">Salveaza</button>
            <button class="btn btn-outline-secondary mr-2" name="pm_renunta1" id="pm_renunta1">Renunta</button> 
    </div>
</div>

@section('pagesspecificscripts')
    <script src="{{asset('js/ProgramarePlati/formProgramareAltele.js')}}"></script>
@stop