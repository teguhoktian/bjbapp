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
                            {{ Form::text('username', null, ['class' => 'form-control', 'placeholder' => __('Username') ]) }}

                            @if ($errors->has('username'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('name', __('Name'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Name') ]) }}

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('email', __('E-Mail'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('email') ? ' has-error' : '' }}">
                            {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('E-Mail') ]) }}

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('password', __('Password'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('password') ? ' has-error' : '' }}">
                            {{ Form::password('password', ['class' => 'form-control', 'placeholder' => __('Password') ]) }}

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('password_confirmation', __('Confirm Password'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => __('Retype Password') ]) }}

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('status', __('Roles'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6">
                            {{ Form::select('roles[]', $roles, null, ['class' => 'form-control select2', 'multiple']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('status', __('Status'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6">
                            <div class="radio">
                                <label>
                                    {{ Form::radio('status', 'Active', true) }}
                                    {{ __('Active') }}
                                </label>
                                <label>
                                    {{ Form::radio('status', 'Nonactive', '') }}
                                    {{ __('Nonactive') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('office_id', __('Office'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('office_id') ? ' has-error' : '' }}">
                            {{ Form::select('office_id', $offices, null, ['class' => 'form-control select2', 'placeholder' => __('Choose Office')]) }}

                            @if ($errors->has('office_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('office_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>                    

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary col-md-offset-3">
                        <i class="fa fa-floppy-o"></i> {{ __('Save') }}
                    </button>
                    <a href="{{ route('user.index') }}" class="btn btn-default">
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
    $(function(){
        $('.select2').select2({ width: '100%'});
    });
</script>
@endpush

