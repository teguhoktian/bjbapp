@extends('admin_template')

@section('content')

    <div class='row'>
        <div class="col-md-12">
            <div class="dashboard-control">
                <form class="form-inline" action="">
                    {{ Form::hidden('start_date', null, ['class' => 'form-control start_date']) }}
                    {{ Form::hidden('end_date', null, ['class' => 'form-control end_date']) }}
                    <div class="form-group">
                        {{ Form::select('goal_id', $goals, null, ['class' => 'form-control select2 goal_id', 'placeholder' => __('Choose')]) }}
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

@endpush

