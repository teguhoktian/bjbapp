@extends('admin_template')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            {{ Form::open(['route' => 'quarterGoal.store', 'class' => 'form-horizontal']) }}
            <div class="box box-primary">
                <div class="box-body">

                    <div class="form-group">
                        {{ Form::label('quarter_id', __('Quarter'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('quarter_id') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ $quarter_goal->quarter->name }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('goal_id', __('Goal'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('goal_id') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ $quarter_goal->goal_detail->goal->name }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('goal_detail_id', __('Goal Detail'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('goal_detail_id') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ $quarter_goal->goal_detail->name }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('amount', __('Goal Amount'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('amount') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ number_format($quarter_goal->amount, 0) }}</p>
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{ route('quarterGoal.index') }}" class="btn btn-default col-md-offset-3">
                        <i class="fa fa-long-arrow-left"></i> {{ __('Back') }}
                    </a>
                    <a href="{{ route('quarterGoal.edit',['id' => $quarter_goal->id]) }}" class="btn btn-success">
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

