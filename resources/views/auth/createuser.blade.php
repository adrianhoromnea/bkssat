@extends('layouts.main')
@section('body')

    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Creeaza un cont nou</div>
      <div class="card-body">
        <form enctype="multipart/form-data" method="POST" action="{{ route('createUser') }}">
            {{ csrf_field() }}

            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Prenume*</label>
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus> 

                        @if ($errors->has('name'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-6 {{ $errors->has('lastname') ? ' has-error' : '' }}">
                        <label for="lastname">Nume*</label>
                        <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" required> 
                        @if ($errors->has('name'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('lastname') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email">Adresa email*</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-6 {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password">Parola*</label>
                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label for="password-confirm">Confirma parola*</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    </div>
                </div> 
            </div>

            <div class="form-group">
                <label for="erpusers">User ERP*</label>  
                <select class="form-control" name="erpusers" id="erpusers_id">
                    <option value="" disabled selected>Selecteaza user ERP</option>
                    @foreach($erpusers as $erpuser)
                        <option value="{{$erpuser->IdUser}}" required>
                            {{$erpuser->Nume}}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('erpusers'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('erpusers') }}</strong>
                    </span>
                @endif
                
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label for="grupuri">Grupuri utilizatori*</label> 
                    <div class="checkbox" id="grupuri">
                        @foreach($roles as $role)
                            <label class="form-check-inline no_indent">
                                <input type="checkbox" value="{{$role->id}}" name="roles[]"> {{" - " . $role->name}}
                            </label>
                        @endforeach
                    </div>  
                    @if ($errors->has('roles'))
                    <span class="help-block text-danger">
                        <strong>{{ $errors->first('roles') }}</strong>
                    </span>
                    @endif
                </div>  
            </div>
            <div class="form-group">
                <div class="form-row">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Creeaza utilizator
                        </button>
                    </div>
                </div>
            </div>

        </form>
      </div>
    </div>

@endsection
