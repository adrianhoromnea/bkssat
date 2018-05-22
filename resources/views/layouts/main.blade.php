<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- jQueryUI CSS -->
  <link rel="stylesheet" href="{{asset('jQueryUI/jquery-ui.min.css')}}">

  <!-- Bootstrap core CSS-->
  <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="{{asset('vendor/datatables/dataTables.bootstrap4.css')}}" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="{{asset('css/sb-admin.css')}}" rel="stylesheet">

  <!-- Grid-->
  <link href="{{asset('css/jsgrid.min.css')}}" rel="stylesheet">
  <link href="{{asset('css/jsgrid-theme.min.css')}}" rel="stylesheet">

  <!--Tables-->
  <link href="{{asset('css/bootstrap-sortable.css')}}" rel="stylesheet">
  <link href="{{asset('css/tables.css')}}" rel="stylesheet">
  
  


  
  <!-- Confirmation messages-->
  <link href="{{asset('css/toastr.min.css')}}" rel="stylesheet">



</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Add base url for AJAX -->
  <input id="baseUrl" type="hidden" value="{{ url('/') }}">
  
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="#">BKS - Modul plati</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <!-- Left bar -->
      @include('includes\leftbar')

      <!-- Top bar  -->
      @include('includes\topbar')
    </div>
  </nav>

  <!-- Body -->
  <div class="content-wrapper">
    @yield('body')
    @include('includes\footer')
    @include('includes\topagetop')    
  </div>

  <!--js scripts -->
  @include('includes\mainscripts')  
    
</body>

</html>
