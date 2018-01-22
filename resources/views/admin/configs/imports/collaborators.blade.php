@extends('adminlte::page')
@section('content_header')
    <h1>Importar Colaboradores plataforma antiga</h1>
@stop
@section('title', 'Imports')
@section('content')
    <div class="box">
        <div class="box-body">
            <a href="{{route('admin.configs.import_json')}}">import</a>
        </div>
    </div>
@stop
@section('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Accept":"application/json"
            }
        });


        $('#getHollidayYear').on('click', function(){
            $.ajax({
                type: "GET" ,
                url: "http://services.sapo.pt/Holiday/GetNationalHolidays?year="+{{\Carbon\Carbon::now()->format('Y')}},
                dataType: "xml",
                success: function(xml) {
                    var arrayDates = []
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


