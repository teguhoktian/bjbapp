@extends('admin_template')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            {{ Form::open(['route' => 'role.store', 'class' => 'form-horizontal']) }}
            <div class="box box-primary">
                <div class="box-body">

                    <div class="form-group">
                        {{ Form::label('name', __('Role Name'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ $role->name }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('permissions', __('Permission'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6">
                            <p class="form-control-static">{{ $role->permissions->pluck('name')->implode(', ') }}</p>
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{ route('role.index') }}" class="btn btn-default col-md-offset-3">
                        <i class="fa fa-long-arrow-left"></i> {{ __('Back') }}
                    </a>
                    <a href="{{ route('role.edit',['id' => $role->id]) }}" class="btn btn-success">
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

