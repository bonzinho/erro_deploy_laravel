@include('_common._alerts')
<div class="box-body" id="steps">
    <h3>Conta</h3>
    <section>
        <div class="form-group">
                <div class="box-header with-border">
                    <h3 class="box-title">Conta</h3> <span id="error_step1" style="color:red; float:right; font-weight: 500"></span>
                </div>
            <div class="radio">
                <label>
                    <input type="radio" value="0" id="selectAccount0" class="inline" name="selectAccount" data-msg-required="Selecione se já tem ou não conta registada" required>Registar nova conta
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" value="1" id="selectAccount1" name="selectAccount" required>Já tenho conta
                </label>
            </div>
        </div>

        <div id="registar" style="display:none;">
            <div class="box-body">
                <div class="form-group">
                    <div class="box-header with-border">
                        <h3 class="box-title">Dados de registo</h3>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">Denominação</label>
                    <input type="text" class="form-control" value="{{ old('name') }}" name="name" id="name" placeholder="Denominação" data-msg-required="Denominação da entidade é obrigatório" required>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="nif">NIF</label>
                    <input type="text" class="form-control" id="nif"  value="{{ old('nif') }}" name="nif" placeholder="NIF/ Centro de custos" data-msg-required="NIF é obrigatório" required>
                    @if ($errors->has('nif'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nif') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="ac_name">Nome do responsável</label>
                    <input type="text" class="form-control" id="ac_name"  value="{{ old('ac_name') }}" name="ac_name" placeholder="Nome do responsável" data-msg-required="Nome do responsável é obrigatório" required>
                    @if ($errors->has('ac_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('ac_name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="address">Morada</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" placeholder="Morada" data-msg-required="Morada é obrigatório" required>
                    @if ($errors->has('address'))
                        <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label for="postal_code">Cod. Postal</label>
                    <input type="text" class="form-control" id="postal_code" value="{{ old('postal_code') }}" name="postal_code" placeholder="Cod. Postal" data-msg-required="Código Postal é obrigatório" required>
                    @if ($errors->has('postal_code'))
                        <span class="help-block">
                            <strong>{{ $errors->first('postal_code') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label for="locality">Localidade</label>
                    <input type="text" class="form-control" id="locality" name="locality" value="{{ old('locality') }}" placeholder="Localidade" data-msg-required="Localidade é obrigatório" required>
                    @if ($errors->has('locality'))
                        <span class="help-block">
                            <strong>{{ $errors->first('locality') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="phone">Telefone</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Telefone" data-msg-required="Telefone é obrigatório" required>
                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Email" data-msg-required="Email é obrigatório" required>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password"  placeholder="Password" data-msg-required="Password é obrigatório" required>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirmar Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmar Password" data-msg-required="Confirmar password é obrigatório" required>
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div id="login" style="display:none;">
            <div class="box-body">
                <div class="form-group">
                    <div class="box-header with-border">
                        <h3 class="box-title">Dados de login</h3>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" id="email" placeholder="Email" data-msg-required="Email é obrigatório" required>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" data-msg-required="Password é obrigatório" required>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <h3>Dados do evento</h3>
    <section>
        <div class="box-body">
            <div class="form-group">
                <div class="box-header with-border">
                    <h3 class="box-title">Dados do Evento</h3>
                </div>
            </div>
            <div class="form-group">
                <label>Natureza do evento</label>
                <select name="nature_id" class="form-control" data-msg-required="Natureza do evento é obrigatório" required>
                    @foreach($naturezas as $natureza)
                        <option value="{{$natureza->id}}">{{$natureza->name}}</option>
                    @endforeach
                </select>
                @if ($errors->has('nature_id'))
                    <span class="help-block">
                            <strong>{{ $errors->first('nature_is') }}</strong>
                        </span>
                @endif
            </div>
            <div class="form-group">
                <label for="denomination">Nome do Evento</label>
                <input type="text" class="form-control" id="denomination" value="{{ old('denomination') }}" name="denomination" placeholder="Denominação" data-msg-required="Nome do evento é obrigatório" required>
                @if ($errors->has('denomination'))
                    <span class="help-block">
                            <strong>{{ $errors->first('denomination') }}</strong>
                        </span>
                @endif
            </div>
            <div class="form-group">
                <label for="number_participants">Numero de participantes estimado</label>
                <input type="number" class="form-control" id="number_participants" value="{{ old('number_participants') }}" name="number_participants" placeholder="Numero de participantes esperado" data-msg-required="Numero de participantes esperado é obrigatório" required>
                @if ($errors->has('number_participants'))
                    <span class="help-block">
                            <strong>{{ $errors->first('number_participants') }}</strong>
                        </span>
                @endif
            </div>
            <div class="form-group">
                <label>Datas & Horas</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="date_time_init" value="{{ old('date_time_init') }}" id="reservationtime" data-msg-required="Data e hora do início e fim do evento é obrigatório" required>
                </div>
                @if ($errors->has('date_time_init'))
                    <span class="help-block">
                            <strong>{{ $errors->first('date_time_init') }}</strong>
                        </span>
                @endif
            </div>
        </div>
    </section>

    <h3>Apoio</h3>
    <section>
        <div class="box-body">
            <div class="form-group">
                <div class="box-header with-border">
                    <h3 class="box-title">Apoio Pretendido</h3>
                </div>
            </div>
            <div class="checkbox">
                @foreach($apoios as $apoio)
                    <label style="margin-right: 20px;">
                        <input type="checkbox" value="{{$apoio->id}}" @if(is_array(old('support_id')) && in_array($apoio->id, old('support_id'))) checked @endif name="support_id[]"> {{$apoio->name}}
                    </label>
                @endforeach
            </div>
            @if ($errors->has('support_id[]'))
                <span class="help-block">
                            <strong>{{ $errors->first('support_id[]') }}</strong>
                        </span>
            @endif
        </div>
    </section>
    <h3>Espaços</h3>
    <section>
        <div class="box-body">
            <div class="form-group">
                <div class="box-header with-border">
                    <h3 class="box-title">Espaços</h3>
                </div>
            </div>
            <div class="invalid"></div>
            <div class="checkbox">
                @foreach($espacos as $espaco)
                    <label>
                    <input type="checkbox" value="{{$espaco->id}}" @if(is_array(old('support_id')) && in_array($espaco->id, old('support_id'))) checked @endif name="space_id[]" data-msg-required="Tem de selecionar pelo menos um espaço" required> {{$espaco->name}}
                    </label>
                        <br/>
                @endforeach
            </div>
            @if ($errors->has('space_id[]'))
                <span class="help-block">
                            <strong>{{ $errors->first('space_id[]') }}</strong>
                        </span>
            @endif
        </div>
    </section>
    <h3>Materiais</h3>
    <section>
        <div class="box-body">
            <div class="form-group">
                <div class="box-header with-border">
                    <h3 class="box-title">Material que vão necessitar</h3>
                </div>
            </div>
            <div class="form-group">
                @foreach($materiais as $material)
                    <p>
                <div class="input-group">
                        <span class="input-group-addon" style="width: 110px;">
                            {{$material->name}}
                            <input type="checkbox" name="material_id[]"  @if(is_array(old('support_id')) && in_array($material->id, old('support_id'))) checked @endif value="{{$material->id}}">
                        </span>
                    <input type="number" min="0" class="form-control" value="{{ old('material_quantity[]') }}" name="material_quantity[]" placeholder="Quantidade">
                </div>
                    </p>
                @endforeach
                @if ($errors->has('material_id[]'))
                    <span class="help-block">
                        <strong>{{ $errors->first('material_id[]') }}</strong>
                    </span>
                @endif
            </div>

        </div>
    </section>
    <h3>Suportes Gráficos</h3>
    <section>
        <div class="box-body">
            <div class="form-group">
                <div class="box-header with-border">
                    <h3 class="box-title">Suportes gráficos</h3>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    @foreach($graphics as $graphic)
                        <label>
                            <input type="checkbox" value="{{$graphic->id}}" @if(is_array(old('support_id')) && in_array($graphic->id, old('support_id'))) checked @endif name="graphic_id[]"> {{$graphic->name}}
                        </label>
                        <br/>
                    @endforeach
                    @if ($errors->has('graphic_id[]'))
                        <span class="help-block">
                        <strong>{{ $errors->first('graphic_id[]') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <h3>Registos audiovisuais</h3>
    <section>
        <div class="box-body">
            <div class="form-group">
                <div class="box-header with-border">
                    <h3 class="box-title">Registos audiovisuais</h3>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    @foreach($audiovisuals as $audiovisual)
                        <label>
                            <input type="checkbox" value="{{$audiovisual->id}}" @if(is_array(old('support_id')) && in_array($audiovisual->id, old('support_id'))) checked @endif name="audiovisual_id[]"> {{$audiovisual->name}}
                        </label>
                        <br/>
                    @endforeach
                </div>
                @if ($errors->has('audiovisual_id[]'))
                    <span class="help-block">
                        <strong>{{ $errors->first('audiovisual_id[]') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </section>
    <h3>Info. Adicional</h3>
    <section>
        <div class="box-body">
            <div class="form-group">
                <div class="box-header with-border">
                    <h3 class="box-title">Info. Adicional</h3>
                </div>
            </div>
            <div class="form-group">
                <label>Plano de trabalho</label>
                <textarea class="form-control" rows="3" name="work_plan" placeholder="Reuniões, Ensaios, logistica, montagem e desmontagem">{{ \Illuminate\Support\Facades\Input::old('work_plan') }}</textarea>
                @if ($errors->has('work_plan'))
                    <span class="help-block">
                        <strong>{{ $errors->first('work_plan') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label>Raider Técnico</label>
                <textarea class="form-control" rows="3" name="technical_raider" placeholder="Requisitos técnicos, som, projecção, desenho de luz, colocação em palco, guião cénico, gravação ou outros elementos relevantes">{{ \Illuminate\Support\Facades\Input::old('technical_raider') }}</textarea>
                @if ($errors->has('technical_raider'))
                    <span class="help-block">
                        <strong>{{ $errors->first('technical_raider') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label>Programa</label>
                <textarea class="form-control" rows="3" name="programme" placeholder="Programa e listagem das sessões, qual o tipo de comunicação que irão fazer e também o respectivo suporte (power point, projecção de vídeo, acetatos ou outros)">{{ \Illuminate\Support\Facades\Input::old('programme') }}</textarea>
                @if ($errors->has('programme'))
                    <span class="help-block">
                        <strong>{{ $errors->first('programme') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label>Programa (Ficheiro)</label>
                <input type="file" class="form-control" id="doc_program" name="doc_program" value="{{ old('doc_program') }}" placeholder="Ficheiro com o programa (PDF)">
                @if ($errors->has('doc_program'))
                    <span class="help-block">
                        <strong>{{ $errors->first('doc_program') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label>Notas</label>
                <textarea class="form-control" rows="3" name="notes" placeholder=""></textarea>
                @if ($errors->has('notes'))
                    <span class="help-block">
                        <strong>{{ $errors->first('notes') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </section>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.min.js"></script>
<script>

    let validator = $('#event_form').validate({

    });

    $("#steps").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        autoFocus: true,
        onStepChanging: function (event, currentIndex, newIndex)
        {

            validator.settings.ignore = ":disabled,:hidden";
            return $('#event_form').valid({errorClass: "invalid"});

        },
        onFinished: function (event, currentIndex) {
            $('#event_form').submit();
        }
    });

    $('input[name=selectAccount]:radio').change(function(){
        value = $('input[name="selectAccount"]:checked').val();
        if(value == 0){
            $('#event_form').attr('action', window.location.protocol +'//'+ window.location.host +'/event/store/client/register');
            $('#login :input').prop('disabled', true);
            $('#registar :input').prop('disabled', false);
            $('#registar').show();
            $('#login').hide();
        }else{
            $('#event_form').attr('action', window.location.protocol +'//'+ window.location.host +'/event/store/client/login');
            $('#registar :input').prop('disabled', true);
            $('#login :input').prop('disabled', false);
            $('#login').show();
            $('#registar').hide();
        }
    });

    //Date range picker with time picker
    $('input[name="date_time_init"]').daterangepicker({
        timePicker: true,
        timePicker24Hour: true,
        timePickerIncrement: 15,
        locale: {
            format: 'MM/DD/YYYY H:mm'
        }
    });


</script>
@endpush



