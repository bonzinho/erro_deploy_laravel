<div class="modal fade" id="modal-{{$collaborator->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Validar Pagamento de {{$collaborator->name}}</h4>
            </div>
            {!! Form::open(['route' => 'admin.financial.pay', 'files' => true]) !!}
            {!! Form::hidden('collaborator_id', $collaborator->id) !!}
            {!! Form::hidden('payment', $collaborator->toPay) !!}
            {!! Form::hidden('extra_hours', $collaborator->horasExtras) !!}
            {!! Form::hidden('normal_hours', $collaborator->horasNormais) !!}
            <div class="modal-body">
                    Total de Horas Extras: <strong>{{$collaborator->horasExtras}} H</strong><br/>
                    Total de Horas Normais: <strong>{{$collaborator->horasNormais}}H</strong><br/>
                    Total a pagar: <strong>{{$collaborator->toPay}} €</strong><br/>
                <div style="margin-top: 20px;" class="form-group has-feedback {{ $errors->has('type') ? 'has-error' : '' }}">
                    {!! Form::text('pad', null, ['placeholder' => 'PAD', 'class' => 'form-control']) !!}
                    <span class="fa  fa-eur form-control-feedback"></span>
                    @if ($errors->has('pad'))
                        <span class="help-block">
                            <strong>{{ $errors->first('pad') }}</strong>
                        </span>
                    @endif
                </div>
                <div style="margin-top: 20px;" class="form-group has-feedback {{ $errors->has('type') ? 'has-error' : '' }}">
                    <label for="receipt">Recibo</label>
                    {!! Form::file('receipt', null, ['placeholder' => 'Recibo', 'class' => 'form-control']) !!}
                    <span class="fa  fa-eur form-control-feedback"></span>
                    @if ($errors->has('receipt'))
                        <span class="help-block">
                            <strong>{{ $errors->first('pad') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>