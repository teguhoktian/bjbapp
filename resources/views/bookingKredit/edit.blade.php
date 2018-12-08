@extends('admin_template')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            {{ Form::model($goal, ['route' => ['bookingKredit.update', $goal->id], 'class' => 'form-horizontal', 'method' => 'PATCH']) }}
            <div class="box box-primary">
                <div class="box-body">
                    <div class="form-group">
                        {{ Form::label('year', __('Year'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('year') ? ' has-error' : '' }}">
                            {{ Form::select('year', $years, '2018', ['class' => 'form-control select2 year', 'placeholder' => __('Choose')]) }}

                             @if ($errors->has('year'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('year') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('quarter_id', __('Quarter'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('quarter_id') ? ' has-error' : '' }}">
                            {{ Form::select('quarter_id', [], null, ['class' => 'form-control select2 quarter_id', 'placeholder' => __('Choose')]) }}

                             @if ($errors->has('quarter_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('quarter_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('user_goal_id', __('Booking Goal'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('user_goal_id') ? ' has-error' : '' }}">
                            {{ Form::select('user_goal_id', [], null, ['class' => 'form-control select2 user_goal_id', 'placeholder' => __('Choose')]) }}

                             @if ($errors->has('user_goal_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('user_goal_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('booking_amount', __('Booking Amount'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('booking_amount') ? ' has-error' : '' }}">
                            {{ Form::text('booking_amount', null, ['class' => 'form-control', 'placeholder' => __('0') ]) }}

                            @if ($errors->has('booking_amount'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('booking_amount') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('noa', __('NoA Booking'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('noa') ? ' has-error' : '' }}">
                            {{ Form::text('noa', null, ['class' => 'form-control', 'placeholder' => __('0') ]) }}

                            @if ($errors->has('noa'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('noa') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('run_off', __('Run Off'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('run_off') ? ' has-error' : '' }}">
                            {{ Form::text('run_off', null, ['class' => 'form-control', 'placeholder' => __('0') ]) }}

                            @if ($errors->has('run_off'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('run_off') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('loan_close', __('Loan Close'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('loan_close') ? ' has-error' : '' }}">
                            {{ Form::text('loan_close', null, ['class' => 'form-control', 'placeholder' => __('0') ]) }}

                            @if ($errors->has('loan_close'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('loan_close') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('booking_date', __('Booking Date'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('booking_date') ? ' has-error' : '' }}">
                            {{ Form::text('booking_date', null, ['class' => 'form-control', 'placeholder' => __('YYYY-MM-DD') ]) }}

                            @if ($errors->has('booking_date'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('booking_date') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary col-md-offset-3">
                        <i class="fa fa-floppy-o"></i> {{ __('Save') }}
                    </button>
                    <a href="{{ route('bookingKredit.index') }}" class="btn btn-default">
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
<script type="text/javascript">
    var data;
    $(function(){

        //Get Triwulan
        $('.year').on('change', function(){
            $.ajax({
                url: '{{ route('bookingKredit.getQuarter') }}',
                dataType: 'json',
                data:{
                    q : $(this).val(),
                    selected: '{{ $goal->userGoal->quarter_goal->quarter->id }}',
                    except: ''
                }
            }).done(function(response){
                console.log(response);
                var toAppend = '<option value>{{ __('Choose') }}</option>';
                //if(typeof data === 'object'){
                    for(var i=0;i<response.length;i++){
                        var selected = (response[i]['id'] == response[i]['selected']) ? 'selected' : '';
                        toAppend += '<option value="'+response[i]['id']+'" '+selected+'>'+response[i]['text']+'</option>';
                    }
                //}
                $('.quarter_id').html(toAppend);

                /* Get Goals
                 *
                 *
                 *
                 *
                 **/
                $('.quarter_id').bind('load change', function(){
                    $.ajax({
                        url: '{{ route('bookingKredit.getGoal') }}',
                        dataType: 'json',
                        data:{
                            q : $(this).val(),
                            selected: '{{ $goal->userGoal->id }}',
                            except: ''
                        }
                    }).done(function(response){
                        console.log(response);
                        var toAppend = '<option value>{{ __('Choose') }}</option>';
                        //if(typeof data === 'object'){
                            for(var i=0;i<response.length;i++){
                                var selected = (response[i]['id'] == response[i]['selected']) ? 'selected' : '';
                                toAppend += '<option value="'+response[i]['id']+'" '+selected+'>'+response[i]['text']+'</option>';
                            }
                        //}
                        $('.user_goal_id').html(toAppend);
                    });
                }).change();
                /* End Get Goals */

            });
        }).change();

        
    });
</script>
@endpush

