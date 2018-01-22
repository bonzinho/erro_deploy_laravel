@extends('adminlte::page')
@section('content_header')
    @include('_common._alerts')
    <div class="row">
        <div class="col-xs-2">
            <a href="{{route('admin.events.show', [$event->id, 'admin'])}}" type="button" class="btn btn-block btn-default btn-xs">Voltar</a>
        </div>
        <div class="col-xs-10"></div>
    </div>
@stop

@section('title', 'RECEITAS - ' . $event->state->name)
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger" id="errors" style="display: none;"></div>
        </div>
        <div class="col-md-8">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><strong>Receitas do evento {{$event->denomination}}</strong></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="listRecipes" class="table table-hover table-striped"></table>
                    @if($event->schedule_balancete == false || $event->technic_balancete == false)
                    <div class="container-fluid" style="margin-top: 60px" id="addEditForm">
                        <div class="form-inline">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Descrição" id="desc">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Preço" id="value">
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="group">
                                    @if(!$event->technic_balancete && auth()->user()->hasRole(['gestor', 'su', 'gestor_tecnico'])))<option value="{{\App\Entities\Expense::GESTAO_TECNICA}}">Gestor técnico</option>@endif
                                    @if(!$event->schedule_balancete && auth()->user()->hasRole(['gestor', 'su', 'gestor_agenda']))<option value="{{\App\Entities\Expense::GESTAO_AGENDA}}">Gestor agenda</option>@endif
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="CCO / Fatura" id="cco">
                            </div>
                            <button onclick="addData()" id="btnAdd" class="btn btn-success">Adicionar</button>
                            <span id="btnUpdate" style="display: none;">
                                <span id="inputIDUpdate"></span>
                                <button id="edit" onclick="updateData()" class="btn btn-success">Editar</button>
                                <button onclick="resetForm()" id="edit" class="btn btn-danger">Cancelar</button>
                            </span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><strong>Balanço</strong></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            TOTAL DESPESAS
                            <span class="badge badge-primary badge-pill" id="badge-expense"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-info"><strong>RECEITA TECNICA</strong></span>
                            <span class="badge badge-primary badge-pill" id="badge-recipe-tech"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-warning"><strong>RECEITA AGENDA</strong></span>
                            <span class="badge badge-primary badge-pill" id="badge-recipe-sche"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>TOTAL RECEITAS</strong>
                            <span class="badge badge-primary badge-pill" id="badge-recipe"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>BALANÇO</strong>
                            <span class="badge badge-primary badge-pill" id="badge-balance"></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    $( document ).ready(function() {
        var modalLoading = '<div class="modal" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false" role="dialog">\
                                <div class="modal-dialog">\
                                    <div class="modal-content">\
                                        <div class="modal-header">\
                                            <h4 class="modal-title">Aguarde...</h4>\
                                        </div>\
                                        <div class="modal-body">\
                                            <div class="progress">\
                                              <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"\
                                              aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%; height: 40px">\
                                              </div>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>';
        $(document.body).append(modalLoading);
        $("#pleaseWaitDialog").modal("show");
        setExpensesTotal();
        initTable();
    });


    getBalanceState();
    let role = '{{auth()->user()->roles->first()->name}}';
    let list = null;
    let expense = 0;
    let sche_balance_close;
    let tech_balance_close;

    function getBalanceState(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Accept":"application/json"
            }
        });

        $.ajax({
            type: "GET" ,
            url: '{{ url('/admin/events/balance/balance_state')}}' + '/' + '{{$event->id}}',
            datatType : 'JSON',
            success: function(e) {
                tech_balance_close = e.tech;
                sche_balance_close = e.sche;
            }
        });
    }

    function addDataAjax(data){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Accept":"application/json"
            }
        });

        $.ajax({
            type: "POST" ,
            url: '{{url("/admin/events/balance/recipes")}}',
            datatType : 'JSON',
            data: {
                "event_id": '{{$event->id}}',
                description: formatDesc(data.description),
                value: data.value,
                group: data.group,
                cco: data.cco
            },
            success: function(e) {
                cleanForm();
                setList(e.data);
                setGroupRecipes(e.data);
                setRecipesTotal(e.data);
                setBalance(e.data);
                list = e.data;
                $("#pleaseWaitDialog").modal("hide");
            }
        });
    }

    function updateDataAjax(data){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Accept":"application/json"
            }
        });

        $.ajax({
            type: "POST" ,
            url: '{{url("/admin/events/balance/update_recipes/")}}' + '/' +data.id,
            datatType : 'JSON',
            data: {
                description: formatDesc(data.description),
                value: data.value,
                group: data.group,
                cco: data.cco,
            },
            success: function(e) {
                document.getElementById('idUpdate').innerHTML = "";
                resetForm();
                setList(e.data);
                setGroupRecipes(e.data);
                setRecipesTotal(e.data);
                setBalance(e.data);
                list = e.data;
                $("#pleaseWaitDialog").modal("hide");
            }
        });
    }

    function deleteDataAjax(data){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Accept":"application/json"
            }
        });

        $.ajax({
            type  : 'POST',
            url: '{{ url('/admin/events/balance/delete_recipes') }}'+'/'+data.id + '/' + data.event_id,
            datatType : 'JSON',
            data: {
              _method: 'DELETE'
            },
            success: function(e) {
                setList(e.data);
                setGroupRecipes(e.data);
                setRecipesTotal(e.data);
                setBalance(e.data);
                list = e.data;
                $("#pleaseWaitDialog").modal("hide");
            }
        });
    }

    function initTable(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Accept":"application/json"
            }
        });

        $.ajax({
            type: "GET" ,
            url: '{{ url("/admin/events/balance/recipes/" . $event->id) }}',
            datatType : 'JSON',
            success: function(e) {
                setList(e.data);
                setGroupRecipes(e.data); // por grupo
                setRecipesTotal(e.data);
                setBalance(e.data);
                list = e.data;
                $("#pleaseWaitDialog").modal("hide");
            }
        });
    }

    function setRecipesTotal(list){
        document.getElementById('badge-recipe').innerHTML = formatValue(getTotal(list));
    }

    function setExpensesTotal(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Accept":"application/json"
            }
        });

        $.ajax({
            type: "GET" ,
            url:  '{{url('/admin/events/balance/total_expenses')}}'+'/'+'{{$event->id}}',
            datatType : 'JSON',
            success: function(e){
                expense = e.data;
                document.getElementById('badge-expense').innerHTML = formatValue(e.data);
            }
        });
    }

    // verificar os totais de cada grupo
    function setGroupRecipes(list){
        totalTech = 0;
        totalSche = 0;
        for(let key in list){
            if(list[key].group == '{{\App\Entities\Recipe::GESTAO_TECNICA}}') totalTech += list[key].value;
            if(list[key].group == '{{\App\Entities\Recipe::GESTAO_AGENDA}}') totalSche += list[key].value;
        }
        document.getElementById('badge-recipe-tech').innerHTML = formatValue(totalTech);
        document.getElementById('badge-recipe-sche').innerHTML = formatValue(totalSche);
    }

    function setBalance(list){
        document.getElementById('badge-balance').innerHTML = formatValue(getTotal(list) - expense);
    }


    function getTotal(list){
        let total = 0;
        for(let key in list){
            total += list[key].value;
        }
        return total;
    }

    function setList(list){
        document.getElementById('listRecipes').innerHTML = "";
        let table = '<thead><tr><th>Descrição</th><th>Preço</th><th>Tipo</th><th>CCO / Fatura</th><th>Acções</th></tr></thead><tbody>';
        for(let key in list){
            if(sche_balance_close == 1 && list[key].group == 1){
                table += `
                    <tr>
                    <td>${formatDesc(list[key].description)}</td>
                    <td>${formatGroup(list[key].group)}</td>
                    <td>${formatValue(list[key].value)}</td>
                    <td>${list[key].cco}</td>
                    <td></td>
                </tr>
            `;
            }else if(tech_balance_close == 1 && list[key].group == 0){
                table += `
                    <tr>
                    <td>${formatDesc(list[key].description)}</td>
                    <td>${formatValue(list[key].value)}</td>
                    <td>${formatGroup(list[key].group)}</td>
                    <td>${list[key].cco}</td>
                    <td></td>
                </tr>
            `;
            }else{
                table += `
                    <tr>
                    <td>${formatDesc(list[key].description)}</td>
                    <td>${formatValue(list[key].value)}</td>
                    <td>${formatGroup(list[key].group)}</td>
                    <td>${list[key].cco}</td>
                    <td>`;

                if(list[key].group == '{{\App\Entities\Expense::GESTAO_AGENDA}}'){
                    if(role == 'su' || role == 'gestor' || role == 'gestor_financeiro' || role == 'gestor_agenda'){
                        table += `<div class="btn-group btnEditAll btnEdit-${list[key].group}">
                                    <button type="button" class="btn btn-danger">Acções</button>
                                    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#" onclick="setUpdate(${key})">Editar</a></li>
                                        <li class="divider"></li>
                                        <li><a href="javascript:void(0)" onclick="deleteData(${key})">Apagar</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>`;
                    }else{
                        table += '</td></tr>'
                    }

                }else if(list[key].group == '{{\App\Entities\Expense::GESTAO_TECNICA}}'){

                    if(role == 'su' || role == 'gestor' || role == 'gestor_financeiro' || role == 'gestor_tecnico'){
                        table += `<div class="btn-group btnEditAll btnEdit-${list[key].group}">
                                        <button type="button" class="btn btn-danger">Acções</button>
                                        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                                            <span class="caret"></span>
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#" onclick="setUpdate(${key})">Editar</a></li>
                                            <li class="divider"></li>
                                            <li><a href="javascript:void(0)" onclick="deleteData(${key})">Apagar</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>`;
                    }else{
                        table += '</td></tr>'
                    }
                }



            }
        table += '</tbody>';
        document.getElementById('listRecipes').innerHTML = table;
    }
    }

    function formatDesc(desc){
        let str = desc.toLowerCase();
        str = str.charAt(0).toUpperCase() + str.slice(1); // get na primeira letra da string e passa para upper case e  faz a conctenação com a restante stringa aprtir da posição 1
        return str;
    }

    function formatValue(value){
        let str = parseFloat(value).toFixed(2) + ""; // +"" para poder ficar string
        str = str.replace(".", ",");
        str = "€ " + str;
        return str;
    }

    function formatGroup(value){
        str = value;
        if(value == '{{\App\Entities\Expense::GESTAO_AGENDA}}'){
            value = "<span class='text-warning'><strong>Gestor de agenda</strong></span>";
        }
        if(value == '{{\App\Entities\Expense::GESTAO_TECNICA}}'){
            value = "<span class='text-info'><strong>Gestor técnico</strong></span>"
        }
        return value;
    }

    function addData(){
        if(!validation()){
            return;
        }
        $("#pleaseWaitDialog").modal("show");
        let description = document.getElementById('desc').value;
        let value = document.getElementById('value').value;
        let group = document.getElementById('group').value;
        let cco = document.getElementById('cco').value;
        newData = {"description": description, "value": value, "group": group, "cco": cco};
        addDataAjax(newData);
    }

    function updateData(){
        if(!validation()){
            return;
        }
        $("#pleaseWaitDialog").modal("show");
        let id = document.getElementById('idUpdate').value;
        let description = document.getElementById('desc').value;
        let value = document.getElementById('value').value;
        let group = document.getElementById('group').value;
        let cco = document.getElementById('cco').value;
        newData = {"id": id, "description": description, "value": value, "group": group, "cco": cco};
        updateDataAjax(newData);
    }

    function deleteData(id){
        if(confirm("Apagar esta receita?")){
            deleteDataAjax(list[id])
        }
    }

    function cleanForm(){
        document.getElementById('desc').value = "";
        document.getElementById('value').value = "";
        document.getElementById('errors').style.display = "none";
        document.getElementById('cco').value = "";
    }

    function setUpdate(id){
        let obj = list[id];
        document.getElementById('desc').value = obj.description;
        document.getElementById('value').value = obj.value;
        document.getElementById('group').value = obj.group;
        document.getElementById('cco').value = obj.cco;
        document.getElementById('btnUpdate').style.display = "inline-block";
        document.getElementById('btnAdd').style.display = "none";
        document.getElementById('inputIDUpdate').innerHTML = '<input type="hidden" id="idUpdate" value="'+obj.id+'">'
    }

    function resetForm(){
        cleanForm();
        document.getElementById('btnUpdate').style.display = "none";
        document.getElementById('btnAdd').style.display = "inline-block";
    }

    function validation(){
        let description = document.getElementById("desc").value;
        let value = document.getElementById("value").value;
        let group = document.getElementById("group").value;
        let cco = document.getElementById("cco").value;
        let errors = "";

        if(description === ""){
            errors += '<p>Preencha o campo descrição</p>';
        }

        if(value === ""){
            errors += '<p>Preencha o campo preço</p>';
        }else if(value != parseFloat(value)){
            errors += '<p>Preencha o preço com um valor válido</p>';
        }

        /*if(cco === ""){
            errors += '<p>Preencha o campo CCO</p>';
        }*/

        if(group === ""){
            errors += '<p>Selecione o grupo da receita</p>';
        }else if(group != '{{\App\Entities\Recipe::GESTAO_AGENDA}}' && group != '{{\App\Entities\Recipe::GESTAO_TECNICA}}'){
            errors += '<p>Por favor faça refresh à página e volte a selecionar o grupo da receita</p>';
        }

        if(errors != ""){
            document.getElementById('errors').style.display = "block";
            document.getElementById("errors").innerHTML = "<strong>ERROS:</strong>" + errors;
            return 0;
        }else{
            return 1
        }
    }


    /*function verifyForm(){
        let select = document.getElementById('group');
        let btnEditTech = document.getElementsByClassName('btnEdit-0');
        let btnEditSche = document.getElementsByClassName('btnEdit-1');
        if(tech_balance_close == 1 && sche_balance_close == 0){
            select.removeChild(select.options[0]);
            console.log(btnEditTech);
            for(let key in btnEditTech){
                btnEditTech[key].innerHTML = "";
            }
        }else if(sche_balance_close == 1 && tech_balance_close == 0){
            //Retirar opçãp de balancete de agenda
            select.removeChild(select.options[1]);
            for(let key in btnEditSche){
                btnEditSche[key].innerHTML = "";
            }

        }else if(sche_balance_close == 1 && tech_balance_close == 1){
            document.getElementById('addEditForm').innerHTML = "";
            let all = document.getElementsByClassName('btnEditAll');
            for(let key in all){
                all[key].innerHTML = "";
            }
        }
    }*/

</script>
@endpush
