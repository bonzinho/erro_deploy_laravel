@extends('adminlte::page')
@section('content_header')
        <div class="row">
            <div class="col-md-6">
                <h1>Enviar email dinâmico</h1>
            </div>
        </div>
@stop

@section('title', 'Enviar email dinâmico')

@section('content')
        <div class="row">
            <div class="col-md-12">
                {!! Form::open(['route' => 'admin.collaborators.dynamic_email_send', 'method' => 'post', 'files' => true]) !!}
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Compose New Message</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <select name="type" class="form-control">
                                <option value="{{\App\Entities\Collaborator::HOSPEDEIRO}}">Hospedeiros(as)</option>
                                <option value="{{\App\Entities\Collaborator::TECNICO}}">Tecnicos(as)</option>
                                <option value="3">Todos</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="subject" placeholder="Assunto">
                        </div>
                        <div class="form-group">
                    <textarea id="compose-textarea" name="message" class="form-control" style="height: 300px"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="btn btn-default btn-file">
                                <i class="fa fa-paperclip"></i> Attachment
                                <input type="file" name="attachment">
                            </div>
                            <p class="help-block">Max. 32MB</p>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="pull-right">
                           <!-- <button type="button" class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button> -->
                            <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Enviar</button>
                        </div>
                        <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Cancelar</button>
                    </div>
                    <!-- /.box-footer -->
                </div>
                {!! Form::close() !!}
            </div>
        </div>

@stop

@push('js')
<script>
    $(function () {
        $("#compose-textarea").wysihtml5();
    });
</script>
@endpush



