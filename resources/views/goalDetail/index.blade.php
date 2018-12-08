@extends('admin_template')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="col-md-6 no-padding">
                        <a href="{{ route('goalDetail.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> {{ __('Add Goal Detail') }}</a>
                    </div>
                    <div class="col-md-6"></div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Goal Name') }}</th>
                                    <th>{{ __('Name') }}</th>
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
                    'url': '{{ route('goalDetail.data') }}',
                    'error': function(respose){
                        if(respose.status == '401'){
                            location.reload();
                        }
                    }
                },
                columns:[
                    { data: 'id', name: 'id' },
                    { data: 'goal.name', name: 'goal.name'},
                    { data: 'name', name: 'name'},
                    { data: 'action', name: 'action'}
                ]
            });
        });
    </script>
@endpush

