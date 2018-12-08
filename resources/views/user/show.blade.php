@extends('admin_template')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            {{ Form::open(['route' => 'user.store', 'class' => 'form-horizontal']) }}
            <div class="box box-primary">
                <div class="box-body">

                    <div class="form-group">
                        {{ Form::label('username', __('Username'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-4 {{ $errors->has('username') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ $user->username }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('name', __('Name'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ $user->name }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('email', __('E-Mail'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('email') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('roles', __('Roles'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6">
                            <p class="form-control-static">{{ $user_roles }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('status', __('Status'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6">
                            <p class="form-control-static">{{ $user->status }}</p>
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{ route('user.index') }}" class="btn btn-default col-md-offset-3">
                        <i class="fa fa-long-arrow-left"></i> {{ __('Back') }}
                    </a>
                    <a href="{{ route('user.edit',['id' => $user->id]) }}" class="btn btn-success">
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

