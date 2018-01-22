@extends('adminlte::page')
@section('content_header')
        <div class="row">
            <div class="col-md-6">
                <h1>Inserir novo Colaborador</h1>
            </div>
        </div>
@stop

@section('title', 'Inseriri novc colaborador')

@section('content')
        <div class="row">
            <div class="col-md-6">
                {!! Form::open(['route' => 'admin.collaborators.store', 'method' => 'post', 'files' => true]) !!}
                {!! csrf_field() !!}

                <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                           placeholder="Nome completo">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('student_number') ? 'has-error' : '' }}">
                    <input type="text" name="student_number" class="form-control" value="{{ old('student_number') }}"
                           placeholder="Número de estudante">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('student_number'))
                        <span class="help-block">
                            <strong>{{ $errors->first('student_number') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('genre') ? 'has-error' : '' }}">
                    <select name="genre" class="form-control">
                        <option value="male">Masculino</option>
                        <option value="female">Feminino</option>
                    </select>
                    <span class="fa fa-genderless form-control-feedback"></span>
                    @if ($errors->has('genre'))
                        <span class="help-block">
                            <strong>{{ $errors->first('genre') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('type') ? 'has-error' : '' }}">
                    <select name="type" class="form-control">
                        <option value="1">Hospedeiro(a)</option>
                        <option value="0">Tecnico(a)</option>
                        <option value="2">Misto</option>
                    </select>
                    <span class="fa  fa-universal-access form-control-feedback"></span>
                    @if ($errors->has('type'))
                        <span class="help-block">
                            <strong>{{ $errors->first('type') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                           placeholder="Email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('address') ? 'has-error' : '' }}">
                    <input type="text" name="address" class="form-control" value="{{ old('address') }}"
                           placeholder="Morada">
                    <span class="fa fa-address-book form-control-feedback"></span>
                    @if ($errors->has('address'))
                        <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('postal_code') ? 'has-error' : '' }}">
                    <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code') }}"
                           placeholder="Código Postal">
                    <span class="fa fa-address-book form-control-feedback"></span>
                    @if ($errors->has('postal_code'))
                        <span class="help-block">
                            <strong>{{ $errors->first('postal_code') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('locality') ? 'has-error' : '' }}">
                    <input type="text" name="locality" class="form-control" value="{{ old('locality') }}"
                           placeholder="Localidade">
                    <span class="fa fa-address-book form-control-feedback"></span>
                    @if ($errors->has('locality'))
                        <span class="help-block">
                            <strong>{{ $errors->first('locality') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('nif') ? 'has-error' : '' }}">
                    <input type="text" name="nif" class="form-control" value="{{ old('nif') }}"
                           placeholder="NIF">
                    <span class="fa fa-address-card-o form-control-feedback"></span>
                    @if ($errors->has('nif'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nif') }}</strong>
                        </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary btn-block btn-flat">Inserir</button>
            </div>
            <div class="col-md-6">
                    <div class="form-group has-feedback {{ $errors->has('phone') ? 'has-error' : '' }}">
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}"
                               placeholder="Telefone">
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                        @if ($errors->has('phone'))
                            <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('cc') ? 'has-error' : '' }}">
                        <input type="text" name="cc" class="form-control" value="{{ old('cc') }}"
                               placeholder="CC">
                        <span class="fa fa-address-card-o form-control-feedback"></span>
                        @if ($errors->has('cc'))
                            <span class="help-block">
                            <strong>{{ $errors->first('cc') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('iban') ? 'has-error' : '' }}">
                        <input type="text" name="iban" class="form-control" value="{{ old('iban') }}"
                               placeholder="IBAN">
                        <span class="fa fa-address-card-o form-control-feedback"></span>
                        @if ($errors->has('iban'))
                            <span class="help-block">
                            <strong>{{ $errors->first('iban') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('cv') ? 'has-error' : '' }}">
                        <input type="file" id="cv" name="cv" class="form-control" value="{{ old('cv') }}"
                               placeholder="CV">
                        <p class="help-block">{{ trans('adminlte::adminlte.help-input-cv-collaborator') }}</p>
                        <span class="fa fa-file-word-o form-control-feedback"></span>
                        @if ($errors->has('cv'))
                            <span class="help-block">
                            <strong>{{ $errors->first('cv') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('photo') ? 'has-error' : '' }}">
                        <input type="file" id="photo" name="photo" class="form-control" value="{{ old('photo') }}"
                               placeholder="Fotografia">
                        <p class="help-block">{{ trans('adminlte::adminlte.help-input-photo-collaborator') }}</p>
                        <span class="fa fa-image form-control-feedback"></span>
                        @if ($errors->has('photo'))
                            <span class="help-block">
                            <strong>{{ $errors->first('photo') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                        <input type="password" name="password" class="form-control"
                               placeholder="Senha">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        @if ($errors->has('password'))
                            <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                        <input type="password" name="password_confirmation" class="form-control"
                               placeholder="Repetir Senha">
                        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                        @endif
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
@stop



