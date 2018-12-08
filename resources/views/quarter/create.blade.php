@extends('admin_template')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            {{ Form::open(['route' => 'quarter.store', 'class' => 'form-horizontal']) }}
            <div class="box box-primary">
                <div class="box-body">

                    <div class="form-group">
                        {{ Form::label('year', __('Quarter Year'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('year') ? ' has-error' : '' }}">
                            {{ Form::text('year', '', ['class' => 'form-control', 'placeholder' => __('Quarter Year') ]) }}

                            @if ($errors->has('year'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('year') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('number', __('Quarter'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('number') ? ' has-error' : '' }}">
                            {{ Form::select('number', ['1' => '1', '2' => '2','3' => '3','4' => '4'], null, ['class' => 'form-control select2 number', 'placeholder' => __('Choose')]) }}

                            @if ($errors->has('number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('start_date', __('Start Date'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('start_date') ? ' has-error' : '' }}">
                            {{ Form::text('start_date', '', ['class' => 'form-control', 'placeholder' => __('Start Date') ]) }}

                            @if ($errors->has('start_date'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('start_date') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('end_date', __('End Date'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('end_date') ? ' has-error' : '' }}">
                            {{ Form::text('end_date', '', ['class' => 'form-control', 'placeholder' => __('End Date') ]) }}

                            @if ($errors->has('end_date'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('end_date') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary col-md-offset-3">
                        <i class="fa fa-floppy-o"></i> {{ __('Save') }}
                    </button>
                    <a href="{{ route('quarter.index') }}" class="btn btn-default">
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

