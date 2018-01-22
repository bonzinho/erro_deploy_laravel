<div class="modal fade" id="modal-{{$f->collaborator->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Adicionar Recibo {{$f->collaborator->name}}</h4>
            </div>
            {!! Form::open(['route' => ['admin.financial.add_receipt', $f->id], 'files' => true, 'method' => 'PUT']) !!}
            {!! Form::hidden('collaborator_id', $f->collaborator->id) !!}
            <div class="modal-body">
                <div style="margin-top: 20px;" class="form-group has-feedback {{ $errors->has('type') ? 'has-error' : '' }}">
                    <label for="receipt">Recibo</label>
                    {!! Form::file('receipt', null, ['placeholder' => 'Recibo', 'class' => 'form-control']) !!}
                    <span class="fa  fa-eur form-control-feedback"></span>
                    @if ($errors->has('receipt'))
                        <span class="help-block">
                            <strong>{{ $errors->first('receipt') }}</strong>
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