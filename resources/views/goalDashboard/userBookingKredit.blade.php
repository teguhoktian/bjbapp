@extends('admin_template')

@section('content')

    <div class='row'>
        <div class="col-md-12">
            <div class="dashboard-control">
                <form class="form-inline">
                    {{ Form::hidden('start_date', null, ['class' => 'form-control start_date']) }}
                    {{ Form::hidden('end_date', null, ['class' => 'form-control end_date']) }}
                    <div class="form-group">
                        {{ Form::select('goal_id', $goals, $request->goal_id, ['class' => 'form-control select2 goal_id', 'placeholder' => __('Choose')]) }}
                    </div>
                    <button type="button" class="btn btn-primary" id="daterangepicker">
                        <i class="fa fa-calendar"></i>  <span>{{ __('Date Range') }}</span>
                    </button>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search"></i> {{ __('Show') }}
                    </button>
                </form>
            </div>
        </div>

        @if(!empty($request->goal_id))
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body no-padding" id="chart1">

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-body no-padding" id="chart2">

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-body no-padding" id="chart3">

                </div>
            </div>
        </div>
        @endif

    </div><!-- /.row -->
@endsection

@push('styles')
<!-- daterange picker -->
<link rel="stylesheet" href="{{ asset('admin-lte/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('admin-lte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush

@push('script')
<!-- Daterange Picker -->
<script src="{{ asset('admin-lte/bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('admin-lte/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript">
    $(function(){

        var startDate = '{{ $request->start_date }}';
        var endDate = '{{ $request->end_date }}';

        if(startDate == '' && endDate == ''){
            $('.start_date').val(moment().subtract(29, 'days').format('YYYY-MM-DD'));
            $('.end_date').val(moment().format('YYYY-MM-DD'));
            $('#daterangepicker span').html(moment().format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
        }else{
            $('.start_date').val(startDate);
            $('.end_date').val(endDate);
            $('#daterangepicker span').html(moment(startDate).format('MMMM D, YYYY') + ' - ' + moment(endDate).format('MMMM D, YYYY'));
        }

        $('#daterangepicker').daterangepicker({
            ranges   : {
                '{{ __('Today') }}' : [moment(), moment()],
                '{{ __('Yesterday') }}' : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '{{ __('Last 7 Days') }}' : [moment().subtract(6, 'days'), moment()],
                '{{ __('Last 30 Days') }}': [moment().subtract(29, 'days'), moment()],
                '{{ __('This Month') }}'  : [moment().startOf('month'), moment().endOf('month')],
                '{{ __('Last Month') }}'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate  : moment()
        },function (start, end) {
            $('#daterangepicker span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $('.start_date').val(start.format('YYYY-MM-DD'));
            $('.end_date').val(end.format('YYYY-MM-DD'));
        });
    });
</script>


<!-- Highchart -->
<script src="//code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="//code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<script type="text/javascript">
Highcharts.chart({
    title: {"text":"Daily Booking Kredit"},
    subtitle: {"text":"{{date('d/m/Y', strtotime($request->start_date)) .' - '. date('d/m/Y', strtotime($request->end_date))}}"},
    yAxis: {
        "title":{
            "text":"Jumlah"
        }
    },
    xAxis: {
        "categories":{!! json_encode($charts['categories']) !!}
    },
    plotOptions: {
        "line":{
            "dataLabels":{
                "enabled":true
            }
        }
    },
    series: [{
        "name":"Booking Kredit",
        "data":{!! json_encode($charts['bookingAmountDS']) !!},
        "color":"#0c2959"
    },{
        "name":"Run Off",
        "data":{!! json_encode($charts['runOffDS']) !!},
        "color":"#990099"
    },{
        "name":"Loan Close",
        "data":{!! json_encode($charts['loanCloseDS']) !!},
        "color":"#ac2925"
    },{
        "name":"Net Growth",
        "data":{!! json_encode($charts['nettBookingDS']) !!},
        "color":"#00a65a"
    }],
    chart: {
        "type":"line",
        "renderTo":"chart1",
        "zoomType":"x"
    },
    colors: ["#0c2959"]
});
</script>
<script type="text/javascript">
    Highcharts.chart({
        title: {
            "text":"Percentage Booking"
        },
        subtitle: {
            "text":"{{ date('d/m/Y', strtotime($request->start_date)) .' - '. date('d/m/Y', strtotime($request->end_date)) }}"
        },
        plotOptions: {
            "pie":{
                "allowPointSelect":true,
                "showInLegend":true,
                "cursor":"pointer",
                "dataLabels":{
                    "enabled":true,
                    "format":"<b>{point.name}</b><br> {point.percentage:.1f} %"
                },
                "colors":["#00a65a","#990099","#ac2925"]
            }
        },series: [
        {
            "name":"Booking Kredit",
            "data":[
            {"name":"Growth Net",
            "y":{!! $charts['nett_booking'] !!},
            "sliced":true,
            "selected":true
        },{
            "name":"Run Off",
            "y":{!! $charts['run_off'] !!}
        },{
            "name":"Loan Close",
            "y":{!! $charts['loan_close'] !!}
        }]
    }],chart: {
        "type":"pie",
        "renderTo":"chart2"
    }
});
</script>
<script type="text/javascript">
Highcharts.chart({
    title: {
        "text":"{!! __('Booking Achievment') !!}"
    },
    yAxis: {
        min: 0,
        max: 200,

        minorTickInterval: 'auto',
        minorTickWidth: 1,
        minorTickLength: 10,
        minorTickPosition: 'inside',
        minorTickColor: '#666',

        tickPixelInterval: 30,
        tickWidth: 2,
        tickPosition: 'inside',
        tickLength: 10,
        tickColor: '#666',
        labels: {
            step: 2,
            rotation: 'auto'
        },
        title: {
            text: 'Achievment'
        },
        plotBands: [{
            from: 0,
            to: 80,
            color: '#DF5353' // green
        }, {
            from: 80,
            to: 100,
            color: '#6bdf51' // yellow
        }, {
            from: 100,
            to: 200,
            color: '#5286df' // 
        }]
    },
    pane: {
        startAngle: -150,
        endAngle: 150,
        background: [{
            backgroundColor: {
                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                stops: [
                    [0, '#FFF'],
                    [1, '#333']
                ]
            },
            borderWidth: 0,
            outerRadius: '109%'
        }, {
            backgroundColor: {
                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                stops: [
                    [0, '#333'],
                    [1, '#FFF']
                ]
            },
            borderWidth: 1,
            outerRadius: '107%'
        }, {
            // default background
        }, {
            backgroundColor: '#DDD',
            borderWidth: 0,
            outerRadius: '105%',
            innerRadius: '103%'
        }]
    },
    series: [
        {
            "name":"Booking Kredit",
            "data":[{!! number_format($charts['achievment'],2) !!}],
            "tooltip":{
                "valueSuffix":"%"
            },
            "plotBands":[
                {
                    "from":0,
                    "to":120
                }
            ]
        }
    ],
    chart: {
        "type":"gauge",
        "renderTo":"chart3"
    }
});
</script>

@endpush
