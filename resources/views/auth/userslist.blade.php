@extends('layouts.main')
@section('body')
  <!-- Breadcrumbs -->
  <div class="container-fluid">
    <!-- breadcrump  -->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          Lista utilizatori
        </li>
      </ol>

    <!-- table -->
    <div class="card mb-3">
          <div class="card-body">
              <a href="{{ route('showCreateUser') }}"><button type="button" class="btn btn-success btn-sm" style="float:right; width:40px" data-toogle="tooltip" title="Adauga utilizator nou" >+</button></a>
          </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

              <thead>
                <tr>
                  <th>Nme</th>
                  <th>Prenume</th>
                  <th>Email</th>
                  <th>Grupuri</th>
                  <th>Actiuni</th>
                </tr>
              </thead>

              <tfoot>
                <tr>
                  <th>Nume</th>
                  <th>Prenume</th>
                  <th>Email</th>
                  <th>Grupuri</th>
                  <th>Actiuni</th>
                </tr>
              </tfoot>

              <tbody>
                @foreach($userslist as $user)
                <tr id="tr_{{$user->id}}">
                  <td>{{$user->lastname}}</td>
                  <td>{{$user->firstname}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->roles}}</td>
                  <td>
                    <a href="{{route('showUpdateUser',['id'=>$user->id])}}"><button type="button" class="btn btn-info btn-sm" style="width:40px" data-toogle="tooltip" title="Modifica date utilizator"><></button></a>
                    <a href="{{route('deleteUser',['id'=>$user->id])}}"><button type="button" class="btn btn-danger btn-sm" style="width:40px" data-toogle="tooltip" title="Sterge utilizator">x</button></a>

                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
  </div>

  <!-- scripts -->
  <script type="text/javascript">
     
  </script>



@stop
