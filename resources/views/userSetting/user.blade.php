@extends('admin_template')

@section('content')


    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            {{ Form::open(['route' => 'user4dxSetting.save', 'class' => 'form-horizontal']) }}
            <div class="box box-primary">
                <div class="box-body">

                    <div class="form-group">
                        {{ Form::label('username', __('Username'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-4 {{ $errors->has('username') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ $user->name }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('first_approval', __('First Approval'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('first_approval') ? ' has-error' : '' }}">
                            {{ Form::select('first_approval', $users, $user->approval_first_id, ['class' => 'form-control select2', 'placeholder' => __('Choose')]) }}

                             @if ($errors->has('first_approval'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('first_approval') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('second_approval', __('Second Approval'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('second_approval') ? ' has-error' : '' }}">
                            {{ Form::select('second_approval', $users, $user->approval_second_id, ['class' => 'form-control select2', 'placeholder' => __('Choose')]) }}

                             @if ($errors->has('second_approval'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('second_approval') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary col-md-offset-3">
                        <i class="fa fa-floppy-o"></i> {{ __('Save') }}
                    </button>
                    <a href="{{ route('profile') }}" class="btn btn-default">
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

