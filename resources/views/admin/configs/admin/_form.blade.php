<div class="row">
    <div class="col-md-12">
        <div class="text-red">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nome']) !!}
        </div>
        <div class="form-group">
            {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
        </div>
        <div class="form-group">
            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
        </div>
        <div class="form-group">
            {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirmar Password']) !!}
        </div>
        <div class="form-group">
            {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Telefone']) !!}
        </div>
        <div class="form-group">
            <div class="form-group">
                <label>Nivel de administrador</label>
                {!! Form::select('role', $roles, null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Adicionar</button>
        </div>
    </div>
</div>
