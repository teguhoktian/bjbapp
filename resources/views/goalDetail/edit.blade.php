@extends('admin_template')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            {{ Form::model($goal_detail, ['route' => ['goalDetail.update', $goal_detail->id], 'class' => 'form-horizontal', 'method' => 'PATCH']) }}
            <div class="box box-primary">
                <div class="box-body">

                    <div class="form-group">
                        {{ Form::label('goal_id', __('Goal'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('goal_id') ? ' has-error' : '' }}">
                            {{ Form::select('goal_id', $goals, null, ['class' => 'form-control select2 goal_id', 'placeholder' => __('Choose')]) }}

                             @if ($errors->has('goal_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('goal_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('name', __('Goal Detail Name'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Name') ]) }}

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary col-md-offset-3">
                        <i class="fa fa-floppy-o"></i> {{ __('Save') }}
                    </button>
                    <a href="{{ route('goalDetail.index') }}" class="btn btn-default">
                        <i class="fa fa-long-arrow-left"></i> {{ __('Back') }}
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

