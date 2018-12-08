@extends('admin_template')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            {{ Form::model($quarter_goal, ['route' => ['quarterGoal.update', $quarter_goal->id], 'class' => 'form-horizontal', 'method' => 'PATCH']) }}
            <div class="box box-primary">
                <div class="box-body">

                    <div class="form-group">
                        {{ Form::label('quarter_id', __('Quarter'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('quarter_id') ? ' has-error' : '' }}">
                            {{ Form::select('quarter_id', $quarters, null, ['class' => 'form-control select2 quarter_id', 'placeholder' => __('Choose')]) }}

                             @if ($errors->has('quarter_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('quarter_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('goal_id', __('Goal'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('goal_id') ? ' has-error' : '' }}">
                            {{ Form::select('goal_id', $goals, $quarter_goal->goal_detail->goal->id, ['class' => 'form-control select2 goal_id', 'placeholder' => __('Choose')]) }}

                             @if ($errors->has('goal_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('goal_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('goal_detail_id', __('Goal Detail'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('goal_detail_id') ? ' has-error' : '' }}">
                            {{ Form::select('goal_detail_id', [], null, ['class' => 'form-control select2 goal_detail_id', 'placeholder' => __('Choose')]) }}

                             @if ($errors->has('goal_detail_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('goal_detail_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('amount', __('Goal Amount'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('amount') ? ' has-error' : '' }}">
                            {{ Form::text('amount', null, ['class' => 'form-control', 'placeholder' => __('Goals Amount') ]) }}

                            @if ($errors->has('amount'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('amount') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary col-md-offset-3">
                        <i class="fa fa-floppy-o"></i> {{ __('Save') }}
                    </button>
                    <a href="{{ route('quarterGoal.index') }}" class="btn btn-default">
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
        $('.goal_id').on('change', function(){
            $.ajax({
                url: '{{ route('quarterGoal.goalDetail') }}',
                dataType: 'json',
                data:{
                    q : $(this).val(),
                    selected: '{{ $quarter_goal->goal_detail->id }}',
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
                $('.goal_detail_id').html(toAppend);
            });
        }).change();
    });
</script>
@endpush

