@extends('admin_template')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            {{ Form::open(['route' => 'quarter.store', 'class' => 'form-horizontal']) }}
            <div class="box box-primary">
                <div class="box-body">

                    <div class="form-group">
                        {{ Form::label('number', __('Quarter'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('number') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ $quarter->name }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('start_date', __('Start Date'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('start_date') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ $quarter->start_date }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('end_date', __('End Date'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('end_date') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ $quarter->end_date }}</p>
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{ route('quarter.index') }}" class="btn btn-default col-md-offset-3">
                        <i class="fa fa-long-arrow-left"></i> {{ __('Back') }}
                    </a>
                    <a href="{{ route('quarter.edit',['id' => $quarter->id]) }}" class="btn btn-success">
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

