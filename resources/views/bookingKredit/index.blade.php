@extends('admin_template')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="col-md-6 no-padding">
                        <a href="{{ route('bookingKredit.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> {{ __('Add Booking Kredit') }}</a>
                    </div>
                    <div class="col-md-6"></div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Quarter') }}</th>
                                    <th>{{ __('Goal') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('% to Daily Goal') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('First Approval') }}</th>
                                    <th>{{ __('Sencond Approval') }}</th>
                                    <th width="1%">&nbsp;</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('admin-lte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}"></link>
<style type="text/css">
    .table td:last-child{
        word-wrap: break-word;
        white-space: nowrap;
    }
</style>
@endpush

@push('script')
    <script src="{{ asset('admin-lte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin-lte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        $(function(){
            $('.table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    'type': 'GET',
                    'url': '{{ route('bookingKredit.data') }}',
                    'error': function(respose){
                        if(respose.status == '401'){
                            location.reload();
                        }
                    }
                },
                columnDefs:[
                {
                    targets: 4,
                    className: 'dt-body-right'
                },
                {
                    searchable: false,
                    targets: 4
                }],
                columns:[
                    { data: 'id', name: 'id' },
                    { data: 'quarter', name: 'quarters.name'},
                    { data: 'goal', name: 'goal_details.name'},
                    { data: 'booking_amount', name: 'booking_amount'},
                    { data: 'percentage_daily_goal', name: 'percentage_daily_goal'},
                    { data: 'booking_date', name: 'booking_date'},
                    { data: 'first_approval_status', name: 'first_approval_status'},
                    { data: 'second_approval_status', name: 'second_approval_status'},
                    { data: 'action', name: 'action'}
                ]
            });
        });
    </script>
@endpush

