@extends('layouts.main')
@section('body')

  <!-- Send info for charging ProgramarePlati JavaScripts-->
  @php
    $jsProgramarePlati = "set";
  @endphp

  <!-- Breadcrumbs -->
  <div class="container-fluid">
    <!-- breadcrump  -->
    <div class="breadcrumb row">
        <div class="col">
          Modifica programare plata -  {{$programare->number}} - din - {{substr($programare->data,0,10)}}. Status: <strong>{{$status}} </strong>
        </div>
        <div class="col">
            @if(auth()->user()->hasAnyRole(['Financiar']) AND $programare->status == 0)
                <a href="{{route('programareplati.trimiteSpreAprobare',$id = $programare->id)}}"><input type="button" class="btn btn-info" value="Trimite spre aprobare" title="Trimite spre aprobare" data-toogle="tooltip" id="btnTrimiteAprobare"></a>
            @endif
            @if(auth()->user()->hasAnyRole(['Financiar']) AND $programare->status == 0)
                <a href="{{route('detaliilista.updateDetaliiProgramarePlata',$id = $programare->id)}}"><input type="button" class="btn btn-outline-secondary" value="Actualizeaza lista" title="Actualizeaza lista" data-toogle="tooltip" id="btnActualizeazaLista"></a>
            @endif
            @if(auth()->user()->hasAnyRole(['Financiar']) AND $programare->status == 2)
            <a href="{{route('programareplati.genereazaPlati',$id = $programare->id)}}"><input type="button" class="btn btn-success" value="Genereaza plati" title="Genereaza plati" data-toogle="tooltip" id="btnGenereazaPlati"></a>
            @endif
            @if(auth()->user()->hasAnyRole(['Aprobator plati']) AND ($programare->status == 1 OR $programare->status == 3))
            <a href="{{route('programareplati.aproba',$id = $programare->id)}}"><input type="button" class="btn btn-info" value="Aproba" title="Aproba" data-toogle="tooltip" id="btnAproba"></a>
            @endif
            @if(auth()->user()->hasAnyRole(['Aprobator plati']) AND ($programare->status == 1 OR $programare->status == 2))
            <a href="{{route('programareplati.respinge',$id = $programare->id)}}"><input type="button" class="btn btn-danger" value="Respinge" title="Respinge" data-toogle="tooltip" id="btnRespinge"></a>
            @endif
            @if(auth()->user()->hasAnyRole(['Aprobator plati']) AND ($programare->status == 1 OR $programare->status == 2 OR $programare->status == 3 OR $programare->status == 5))
            <a href="{{route('programareplati.reanaliza',$id = $programare->id)}}"><input type="button" class="btn btn-warning" value="Reanaliza" title="Trimite spre reanaliza" data-toogle="tooltip" id="btnReanaliza"></a>
            @endif
        </div>
        @if(auth()->user()->hasAnyRole(['Financiar']) AND $programare->status == 2)
        <div class="col">
            <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Export
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <h6 class="dropdown-header"><strong>ING</strong></h6>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('programareplata.export',[$id => $programare->id,0])}}">CSV</a>
                        <a class="dropdown-item" href="{{route('programareplata.export',[$id => $programare->id,1])}}">Excel</a>
                    </div>
            </div>  
        </div>
        @endif

        <div class="col">
            <input type="button" class="btn btn-outline-secondary float-right mr-2 " value="Sistem/Manual" title="Arata alternativ lsite sistem / manual" data-toogle="tooltip" id="btnArataSistemManual">
            <input type="button" class="btn btn-outline-secondary float-right mr-2" value="Antet lista" title="Arata/Ascunde antet lista" data-toogle="tooltip" id="btnArataAntetLista">
        </div>
            
            
    </div>
  </div>

    <!-- form -->
    <input hidden value="{{$programare->id}}" id="idProgramare">
    <div class="container"  id="updateAntet" style= "display:none">
        <div class="card">
            <div class="card-body">
                <form enctype="multipart/form-data" method="POST" action="{{route('updateProgramarePlati',['id'=>$programare->id])}}">
                {{ csrf_field() }}
                    <div class="form-group">
                        <div class="form-row"> 
                            <div class="col-xs-6">
                                <label for="data">Data*</label>
                                <input class="form-control datePickerRestrMonth" id="data" type="text" aria-describedby="nameHelp" placeholder="Data programare" readonly='true' required name="data" value="{{substr($programare->data,0,10)}}">
                                @if ($errors->has('data'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('data') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-row"> 
                            <div class="col-xs-6">
                                <label for="numar">Numar*</label>
                                <input class="form-control" id="numar" type="text" aria-describedby="nameHelp" placeholder="Numar programare" readonly='true' required name="numar" value="{{$programare->number}}">
                                @if ($errors->has('numar'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('numar') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-row"> 
                            <div class="col-md-6">
                                    <label for="cont">Cont*</label>
                                    <div class="input-group">
                                        <select class="form-control" name="cont" id="contBancar" required>
                                            <option value="" selected disabled >Selecteaza contul bancar</option>
                                        @foreach($conturi as $cont)
                                            <option value="{{$cont->idNomContBanca}}" {{ $cont->idNomContBanca == $programare->cont_id ? 'selected' : ''}}>{{$cont->contContabil->SimbolCont . " - " . $cont->ContBanca}}</option>
                                        @endforeach                                       
                                        </select>
                                        @if ($errors->has('cont'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('cont') }}</strong>
                                            </span>
                                        @endif

                                    </div>    
                            </div>
                        </div>

                        <div class="form-row"> 
                            <div class="col-md-6">
                                <label for="extrasBanca">Extras cont*</label>
                                <div class="input-group">
                                    <select class="form-control" name="extrasBanca" id="extrasBanca" required>
                                        <option value="" disabled selected >Selecteaza extrasul de cont</option>
                                        @foreach($extrase as $extras)
                                            <option value="{{$extras->idExtrasBanca}}" {{$extras->idExtrasBanca == $programare->extrascont_id ? 'selected' : ''}}>
                                                {{
                                                'Extras numarul [' 
                                                . $extras->Numar
                                                . '] de la '
                                                . substr($extras->DeLa,0,10)
                                                . ' pana la '
                                                . substr($extras->PanaLa,0,10)
                                                
                                                
                                                }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if(auth()->user()->hasAnyRole(['Financiar']) AND $programare->status == 0)
                                    <div class="input-group-addon"  id="divAddExtras" hidden>
                                            <button type="button" class="btn btn-success btn-sm" style="width:38px;height:38px;margin-left:30px" data-toogle="tooltip" title="Adauga extras cont nou" id="addExtrasCont" >+</button>
                                    </div>
                                    @endif
                                    @if ($errors->has('extrasBanca'))
                                        <span class="help-block text-danger">
                                            <strong>{{ $errors->first('extrasBanca') }}</strong>
                                        </span>
                                    @endif
                                </div>    
                            </div>
                        </div>
                        
                        <div class="form-row"> 
                        <div class="col-md-6">
                            <label for="startNumar">Start numar OP</label>
                            <input class="form-control" id="startNumar" type="number" required name="startNumar" step="1" value="{{$programare->startnumber}}" readonly='true'>
                            <strong><p style="color:red" id="ppErrorNumarOp"></p></strong>
                        </div>
                        </div>

                        <div class="form-row"> 
                        <div class="col-md-6">
                            <label for="descriere">Descriere</label>
                            <textarea class="form-control" id="descriere" type="text-area" aria-describedby="nameHelp" placeholder="Descriere" rows="1" name="descriere">{{$programare->description}}</textarea>
                        </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                            <div class="form-row text-center"> 
                                <div class="col">
                                    @if(auth()->user()->hasAnyRole(['Financiar']) AND $programare->status == 0)
                                    <a href="{{route('listaprogramariplati')}}">            
                                        <button type="button" class="btn" style="margin-right:20px">
                                            Renunta
                                        </button>
                                    </a>
                                    <button type="submit" class="btn btn-primary" style="margin-right:20px">
                                        Modifica antet
                                    </button>
                                    @endif
                                </div>
                            </div>
                    </div>

                </form>
            </div>
        </div>
  </div>
    <!--  header tabele     -->
    @include('includes.tables.programareplati.headertabelepp') 

    <!-- tabel lista solduri -->
    @include('includes.tables.programareplati.detaliiprogramareplata') 
    @include('includes.tables.programareplati.detaliiprogramareplataaltele') 

    <!-- include modals  -->
    @include('includes.modals.programareplati.extrascontCreate')
    @include('includes.modals.programareplati.detaliuprogramareplataUpdate')

    <!-- include variables for Javascripts  -->
    @include ('footer')                                     
@stop
