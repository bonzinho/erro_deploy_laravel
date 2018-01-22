@extends('adminlte::page')
@section('content_header')
    <h1>Feriados</h1>
@stop
@section('title', 'Feriados')
@section('content')
    <div class="box">
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Ano</th>
                    <th>janeiro</th>
                    <th>fevereiro</th>
                    <th>Março</th>
                    <th>Abril</th>
                    <th>Maio</th>
                    <th>Junho</th>
                    <th>Julho</th>
                    <th>Agosto</th>
                    <th>Setembro</th>
                    <th>Outubro</th>
                    <th>Novembro</th>
                    <th>Dezembro</th>
                    <th>
                        <div class="btn-group">
                            <button type="button" class="btn btn-warning">Acções</button>
                            <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#" id="getHollidayYear"><i class="fa fa-plus"></i> Ano</a></li>
                            </ul>
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($holidays as $holliday)
                    <tr>
                        <td>{{$holliday->id}}</td>
                        <td>{{$holliday->janeiro}}</td>
                        <td>{{$holliday->fevereiro}}</td>
                        <td>{{$holliday->marco}}</td>
                        <td>{{$holliday->abril}}</td>
                        <td>{{$holliday->maio}}</td>
                        <td>{{$holliday->junho}}</td>
                        <td>{{$holliday->julho}}</td>
                        <td>{{$holliday->agosto}}</td>
                        <td>{{$holliday->setembro}}</td>
                        <td>{{$holliday->outubro}}</td>
                        <td>{{$holliday->novembro}}</td>
                        <td>{{$holliday->dezembro}}</td>
                        <td></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
@stop
@section('js')
    <script>
        $(function () {
            $('#example1').DataTable({
                'paging'      : false,
                'lengthChange': false,
                'searching'   : true,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : true
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Accept":"application/json"
            }
        });


        $('#getHollidayYear').on('click', function(){

            var fixos = 'http://services.sapo.pt/Holiday/GetHolidaysByMunicipalityId?year=';
            $.ajax({
                type: "GET" ,
                url: fixos+{{\Carbon\Carbon::now()->format('Y')}}+"&municipalityId=1312&includeNational=true",
                dataType: "xml",
                success: function(xml) {
                    var arrayDates = [];
                    var datas = $(xml).find('Date').each(function(index, value){
                        arrayDates.push(value.innerHTML)
                    });
                    addNewHollidays(arrayDates);
                }
            });
        });


        function addNewHollidays(array){
            $.ajax({
                type: "POST" ,
                url: "http://localhost:8000/admin/configs/add_hollidays",
                datatType : 'JSON',
                data: {
                    dates: array
                },
                success: function(e) {
                    console.log(e);
                }
            });
        }


    </script>
@stop


