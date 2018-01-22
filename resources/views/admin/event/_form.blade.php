<div class="box-body" id="steps">
    <h3>Dados do evento</h3>
    <section>
        <div class="box-body">
            <div class="form-group">
                <div class="box-header with-border">
                    <h3 class="box-title">Dados do Evento</h3>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('Natureza do evento') !!}
                {!! Form::select('nature_id', \App\Entities\Nature::pluck('name', 'id'), $event->nature_id, ['class' => 'form-control', 'id' => 'nature_id', 'required', 'data-msg-required' => 'Natureza do evento é obrigatório']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Denominação') !!}
                {!! Form::text('denomination', null, ['id' => 'denomination', 'class' => 'form-control', 'data-msg-required' => 'Nome do evento é obrigatório', 'required', 'placeholder' => 'Denominação']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Numero de participantes estimado') !!}
                {!! Form::number('number_participants', null, ['id' => 'number_participants', 'class' => 'form-control', 'data-msg-required' => 'Numero de participantes esperado é obrigatório', 'required', 'placeholder' => 'Numero de participantes esperado']) !!}
            </div>

            <div class="form-group">
                <label>Datas & Horas</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-clock-o"></i>
                    </div>
                    {!! Form::text('date_time_init', null, ['id' => 'denomination', 'class' => 'form-control pull-right', 'data-msg-required' => 'Data e hora do início e fim do evento é obrigatório', 'required', 'id' => 'reservationtime']) !!}
                </div>
                <!-- /.input group -->
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
                        {!! Form::checkbox('support_id[]', $apoio->id, in_array($apoio->id, $selectedSupports)) !!} {{$apoio->name}}
                    </label>
                @endforeach
            </div>
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
                        {!! Form::checkbox('space_id[]', $espaco->id, in_array($espaco->id, $selectedSpaces)) !!} {{$espaco->name}}
                    </label>
                        <br/>
                @endforeach
            </div>
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
                <?php $x=0; ?>
                @foreach($materiais as $material)
                    <p>
                <div class="input-group">
                        <span class="input-group-addon" style="width: 110px;">
                            {!! Form::checkbox('material_id[]', $material->id, in_array($material->id, $selectedMaterial['id'])) !!} {{$material->name}}
                        </span>
                        @if(in_array($material->id, $selectedMaterial['id']))
                            {!! Form::number('material_quantity[]', $selectedMaterial['quantity'][$x], ['id' => 'material_quantity', 'class' => 'form-control', 'placeholder' => 'Quantidade']) !!}
                            <?php $x++; ?>
                        @else
                            {!! Form::number('material_quantity[]', null, ['id' => 'material_quantity', 'class' => 'form-control', 'placeholder' => 'Quantidade']) !!}
                        @endif
                    </div>
                    </p>
                @endforeach
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
                            {!! Form::checkbox('graphic_id[]', $graphic->id, in_array($graphic->id, $selectedGraphs)) !!} {{$graphic->name}}
                        </label>
                        <br/>
                    @endforeach
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
                            {!! Form::checkbox('audiovisual_id[]', $audiovisual->id, in_array($audiovisual->id, $selectedAudiovisuals)) !!} {{$audiovisual->name}}
                        </label>
                        <br/>
                    @endforeach
                </div>
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
                {!! Form::textarea('work_plan', null, ['placeholder' => 'Reuniões, Ensaios, logistica, montagem e desmontagem', 'rows' => '3', 'class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                <label>Raider Técnico</label>
                {!! Form::textarea('technical_raider', null, ['placeholder' => 'Requisitos técnicos, som, projecção, desenho de luz, colocação em palco, guião cénico, gravação ou outros elementos relevantes', 'rows' => '3', 'class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                <label>Programa</label>
                {!! Form::textarea('programme', null, ['placeholder' => 'Programa e listagem das sessões, qual o tipo de comunicação que irão fazer e também o respectivo suporte (power point, projecção de vídeo, acetatos ou outros)', 'rows' => '3', 'class' => 'form-control']) !!}
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
                {!! Form::textarea('notes', null, ['rows' => '3', 'class' => 'form-control']) !!}
            </div>
        </div>
    </section>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        let validator = $('#event_form').validate({});
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
        //Date range picker with time picker
        $('input[name="date_time_init"]').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            timePickerIncrement: 15,
            locale: {
                format: 'DD-MM-YYYY H:mm'
            }
        });
    });

</script>
@endpush



