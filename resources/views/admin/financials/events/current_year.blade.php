@extends('adminlte::page')
@section('content_header')
    <h1>Balanço do ano corrente ({{\Carbon\Carbon::now()->format('Y')}})</h1>
@stop

@section('title', 'Histórico de pagamentos')
@section('content')
    @include('_common._alerts')

    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="chart" id="events_balance" style="height: 300px; position: relative;"></div>
        </div>
        <div class="col-md-12">
            <!-- BAR CHART -->
            <div class="chart" id="bar-chart" style="height: 300px;"></div>
        </div>
    </div>
    <div class="row" style="margin-top:80px;">
        <div class="col-md-12">
            <!-- BAR CHART -->
            <div class="chart" id="bar-chart" style="height: 300px;"></div>
        </div>
    </div>



@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/morris.js/morris.css') }}">
@stop

@section('js')
    <script src="{{asset('vendor/adminlte/plugins/raphael/raphael.min.js')}}"></script>
    <script src="{{asset('vendor/adminlte/plugins/morris.js/morris.min.js')}}"></script>
    <script type="text/javascript">
        //DONUT CHART
        let donut = new Morris.Donut({
            element: 'events_balance',
            resize: true,
            colors: ["#3c8dbc", "#f56954", "#00a65a"],
            data: [
                {label: "Numero de Eventos", value: '{{$num_event}}'},
                {label: "Despesas em €", value: '{{$expenses}}'},
                {label: "Receitas em €", value: '{{$recipes}}'},
                {label: "Balanço em €", value: '{{$recipes - $expenses}}'},
            ],
            hideHover: 'auto'
        });

        //BAR CHART
        var bar = new Morris.Bar({
            element: 'bar-chart',
            resize: true,
            data: [
                {y: 'janeiro', a: '{{$months['janeiro']['num_evento']}}', b: '{{$months['janeiro']['balanco']}}'},
                {y: 'fevereiro', a: '{{$months['fevereiro']['num_evento']}}', b: '{{$months['fevereiro']['balanco']}}'},
                {y: 'março', a: '{{$months['marco']['num_evento']}}', b: '{{$months['marco']['balanco']}}'},
                {y: 'abril', a: '{{$months['abril']['num_evento']}}', b: '{{$months['abril']['balanco']}}'},
                {y: 'maio', a: '{{$months['maio']['num_evento']}}', b: '{{$months['maio']['balanco']}}'},
                {y: 'junho', a: '{{$months['junho']['num_evento']}}', b: '{{$months['junho']['balanco']}}'},
                {y: 'julho', a: '{{$months['julho']['num_evento']}}', b: '{{$months['julho']['balanco']}}'},
                {y: 'agosto', a: '{{$months['agosto']['num_evento']}}', b: '{{$months['agosto']['balanco']}}'},
                {y: 'setembro', a: '{{$months['setembro']['num_evento']}}', b: '{{$months['setembro']['balanco']}}'},
                {y: 'outubro', a: '{{$months['outubro']['num_evento']}}', b: '{{$months['outubro']['balanco']}}'},
                {y: 'novembro', a: '{{$months['novembro']['num_evento']}}', b: '{{$months['novembro']['balanco']}}'},
                {y: 'dezembro', a: '{{$months['dezembro']['num_evento']}}', b: '{{$months['dezembro']['balanco']}}'},
            ],
            barColors: ['#00a65a', '#f56954'],
            xkey: 'y',
            ykeys: ['a', 'b'],
            labels: ['Num. Eventos', 'Balanço'],
            hideHover: 'auto'
        });
    </script>
@stop


