@extends('layouts.main')
@section('body')

  <!-- Send info for charging ProgramarePlati JavaScripts-->
  @php
    $jsProgramarePlati = "set";
  @endphp
  
  <!-- Breadcrumbs -->
  <div class="container-fluid">
    <!-- breadcrump  -->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
            Adauga o programare plata noua
        </li>
      </ol>

    <!-- form -->
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form enctype="multipart/form-data" method="POST" action="{{route('createProgramarePlati')}}">
                {{ csrf_field() }}
                    <div class="form-group">
                        <div class="form-row"> 
                            <div class="col-xs-6">
                                <label for="data">Data*</label>
                                <input class="form-control datePickerRestrTomorrow" id="data" type="text" aria-describedby="nameHelp" placeholder="Data programare" readonly='true' required name="data">
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
                                <input class="form-control" id="numar" type="text" aria-describedby="nameHelp" placeholder="Numar programare" readonly='true' required name="numar" value="{{$numar}}">
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
                                            <option value="{{$cont->idNomContBanca}}">{{$cont->contContabil->SimbolCont . " - " . $cont->ContBanca}}</option>
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
                                    </select>
                                    <div class="input-group-addon"  id="divAddExtras" hidden>
                                            <button type="button" class="btn btn-success btn-sm" style="width:38px;height:38px;margin-left:30px" data-toogle="tooltip" title="Adauga extras cont nou" id="addExtrasCont" >+</button>
                                    </div>
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
                            <input class="form-control" id="startNumar" type="number" required name="startNumar" step="1">
                            <strong><p style="color:red" id="ppErrorNumarOp"></p></strong>
                        </div>
                        </div>

                        <div class="form-row"> 
                        <div class="col-md-6">
                            <label for="descriere">Descriere</label>
                            <textarea class="form-control" id="descriere" type="text-area" aria-describedby="nameHelp" placeholder="Descriere" rows="1" name="descriere"></textarea>
                        </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                            <div class="form-row text-center"> 
                                <div class="col">
                                    <a href="{{route('listaprogramariplati')}}">
                                        <button type="button" class="btn" style="margin-right:20px">
                                            Renunta
                                        </button>
                                    </a>
                                    <button type="submit" class="btn btn-primary" style="margin-right:20px">
                                        Adauga
                                    </button>
                                </div>
                            </div>
                    </div>

                </form>
            </div>
        </div>
  </div>

  <!-- include modals  -->
  @include('includes.modals.programareplati.extrascontCreate')

@stop
