@extends('admin_template')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            {{ Form::open(['route' => 'office.store', 'class' => 'form-horizontal']) }}
            <div class="box box-primary">
                <div class="box-body">

                    <div class="form-group">
                        {{ Form::label('name', __('Corporate Name'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ $office->corporate->corporate_name }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('name', __('Office Name'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ $office->name }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('code', __('Office Code'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('code') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ $office->code }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('parent', __('Office Parent'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('parent') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ $office->parent()->first()['name'] }}</p>
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{ route('office.index') }}" class="btn btn-default col-md-offset-3">
                        <i class="fa fa-long-arrow-left"></i> {{ __('Back') }}
                    </a>
                    <a href="{{ route('office.edit',['id' => $office->id]) }}" class="btn btn-success">
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

