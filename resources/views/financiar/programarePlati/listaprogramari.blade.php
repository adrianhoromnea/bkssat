@extends('layouts.main')
@section('body')

  <!-- Send info for charging ProgramarePlati JavaScripts-->
  @php
    $jsProgramarePlati = "set";
  @endphp

  <!-- Breadcrumbs -->
  <div class="container-fluid">
    <!-- breadcrump  -->
    <div class="breadcrumb">
        <div class="col-12">
          Lista programari plati 
          @if(auth()->user()->hasAnyRole(['Financiar']))
          <a href="{{route('showCreateListaPp')}}">
            <input type="button" class="btn btn-success float-right" value="+" title="Adauga Lista noua" data-toogle="tooltip">
          </a>
          @endif
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-container">
                <table class="table sortable table-bordered table-hover" id="listaProgramariTable" cellspacing="0" data-toggle="table">
                    <thead>
                      <tr>
                        <th hidden></th>
                        <th>Numar</th>
                        <th>Data</th>
                        <th>Cont bancar</th>
                        <th>Initiator</th>
                        <th>Aprobator</th>
                        <th>Status</th>
                        <th>...</th>
                      </tr>
                    </thead>

                    <tbody>
                      @foreach($listaprogramari as $lista)
                      <tr data-toogle="tooltip" title="Vezi detalii lista" style="cursor:pointer">
                        <td hidden id="{{$lista->id}}"></td>
                        <td>{{$lista->Numar}}</td>
                        <td>{{$lista->Data}}</td>
                        <td>{{$lista->ContBancar}}</td>
                        <td>{{$lista->Initiator}}</td>
                        <td>{{$lista->Aprobator}}</td>
                        <td>{{$lista->Status}}</td>
                        <td></th>
                      </tr>
                      @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>






</div>



@stop
