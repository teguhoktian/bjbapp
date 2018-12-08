@extends('admin_template')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            {{ Form::model($role, ['route' => ['role.update', $role->id], 'class' => 'form-horizontal', 'method' => 'PATCH']) }}
            <div class="box box-primary">
                <div class="box-body">

                    <div class="form-group">
                        {{ Form::label('name', __('Role Name'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Role Name') ]) }}

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('permissions', __('Permission'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6">
                            {{ Form::select('permissions[]', $permissions, null, ['class' => 'form-control select2 permission', 'multiple']) }}
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary col-md-offset-3">
                        <i class="fa fa-floppy-o"></i> {{ __('Save') }}
                    </button>
                    <a href="{{ route('role.index') }}" class="btn btn-default">
                        <i class="fa fa-long-arrow-left"></i> {{ __('Back') }}
                    </a>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
            {{ Form::close() }}
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('admin-lte/bower_components/select2/dist/css/select2.min.css') }}">
@endpush

@push('script')
<script type="text/javascript" src="{{ asset('admin-lte/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script type="text/javascript">
    var data;
    $(function(){
        $('.permission').select2({ 
            width: '100%', 
            allowClear: true, 
            placeholder: '{{ __('Choose') }}'}).trigger('change');
    });
</script>
@endpush

