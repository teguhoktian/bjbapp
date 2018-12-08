@extends('admin_template')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            {{ Form::open(['route' => 'permission.store', 'class' => 'form-horizontal']) }}
            <div class="box box-primary">
                <div class="box-body">

                    <div class="form-group">
                        {{ Form::label('name', __('Permission Name'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ $permission->name }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('roles', __('Role'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('roles') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ $permission->roles->pluck('name')->implode(', ') }}</p>
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{ route('permission.index') }}" class="btn btn-default col-md-offset-3">
                        <i class="fa fa-long-arrow-left"></i> {{ __('Back') }}
                    </a>
                    <a href="{{ route('permission.edit',['id' => $permission->id]) }}" class="btn btn-success">
                        <i class="fa fa-pencil"></i> {{ __('Edit') }}
                    </a>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
            {{ Form::close() }}
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@push('styles')
@endpush

@push('script')
@endpush

