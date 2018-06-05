
<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('js/Popper.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Core plugin JavaScript-->
<script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>
<!-- Page level plugin JavaScript-->
<script src="{{asset('vendor/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('vendor/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.js')}}"></script>

<!-- JQueryUI for all pages-->
<script src="{{asset('jQueryUI/jquery-ui.min.js')}}"></script>


<!-- Custom scripts for all pages-->
<script src="{{asset('js/sb-admin.min.js')}}"></script>
<!-- <script src="{{asset('js/bootstrap_confirmation.min.js')}}"></script> -->

<!-- Custom scripts for this page-->
<script src="{{asset('js/sb-admin-datatables.min.js')}}"></script>
<script src="{{asset('js/toastr.min.js')}}"></script>
<script src="{{asset('js/jsgrid.min.js')}}"></script>
<!-- <script src="{{asset('js/sb-admin-charts.min.js')}}"></script> -->
<script src="{{asset('js/customJQueryUI.js')}}"></script>

<!-- Messages -->
<script>
    //success
    @if(Session::has('success'))
        toastr.options.timeOut = 1000;
        toastr.success("{{Session::get('success')}}");     
    @endif
</script>
<script src="{{asset('js/cmessages.js')}}"></script>

<!-- CRUD spot -->
<script src="{{asset('js/spot_crud.js')}}"></script>

<!-- Scripts for number / text formats -->
<script src="{{asset('js/jquery.number.min.js')}}"></script>

<!-- Scripts for tables -->
<script src="{{asset('js/bootstrap-sortable.js')}}"></script>
<script src="{{asset('js/jquery.doubleScroll.js')}}"></script>





<!-- Custom scripts for certain cases -->
@if(isset($jsProgramarePlati))
    <script src="{{asset('js/programarePlati.js')}}"></script>
@endif







    


