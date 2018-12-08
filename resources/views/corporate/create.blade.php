@extends('admin_template')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            {{ Form::open(['route' => 'corporate.store', 'class' => 'form-horizontal']) }}
            <div class="box box-primary">
                <div class="box-body">

                    <div class="form-group">
                        {{ Form::label('corporate_name', __('Corporate Name'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('corporate_name') ? ' has-error' : '' }}">
                            {{ Form::text('corporate_name', '', ['class' => 'form-control', 'placeholder' => __('Name') ]) }}

                            @if ($errors->has('corporate_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('corporate_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('corporate_ID', __('Corporate ID'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('corporate_ID') ? ' has-error' : '' }}">
                            {{ Form::text('corporate_ID', '', ['class' => 'form-control', 'placeholder' => __('Corporate ID') ]) }}

                            @if ($errors->has('corporate_ID'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('corporate_ID') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary col-md-offset-3">
                        <i class="fa fa-floppy-o"></i> {{ __('Save') }}
                    </button>
                    <a href="{{ route('corporate.index') }}" class="btn btn-default">
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

