@extends('admin_template')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            {{ Form::open(['route' => 'bookingKredit.store', 'class' => 'form-horizontal']) }}
            <div class="box box-primary">
                <div class="box-body">

                    <div class="form-group">
                        {{ Form::label('year', __('Tahun'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('year') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ $goal->userGoal->quarter_goal->quarter->year }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('quarter_id', __('Quarter'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('quarter_id') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ $goal->userGoal->quarter_goal->quarter->name }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('user_goal_id', __('Booking Goal'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('user_goal_id') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ $goal->userGoal->quarter_goal->goal_detail->name }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('booking_amount', __('Booking Amount'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('booking_amount') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ number_format($goal->booking_amount , 2) }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('noa', __('NoA Booking'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('noa') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ $goal->noa }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('run_off', __('Run Off'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('run_off') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ number_format( $goal->run_off ?: 0, 2) }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('loan_close', __('Loan Close'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('loan_close') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ number_format( $goal->loan_close ?: 0, 2) }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('booking_date', __('Booking Date'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('booking_date') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ date("Y/m/d", strtotime($goal->booking_date)) }}</p>
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{ route('bookingKredit.index') }}" class="btn btn-default col-md-offset-3">
                        <i class="fa fa-long-arrow-left"></i> {{ __('Back') }}
                    </a>
                    <a href="{{ route('bookingKredit.edit',['id' => $goal->id]) }}" class="btn btn-success">
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

