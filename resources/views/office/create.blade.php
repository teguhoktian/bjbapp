@extends('admin_template')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            {{ Form::open(['route' => 'office.store', 'class' => 'form-horizontal']) }}
            <div class="box box-primary">
                <div class="box-body">

                    <div class="form-group">
                        {{ Form::label('corporate_id', __('Corporate'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('corporate_id') ? ' has-error' : '' }}">
                            {{ Form::select('corporate_id', $corporates, null, ['class' => 'form-control select2 corporate_id', 'placeholder' => __('Choose')]) }}

                             @if ($errors->has('corporate_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('corporate_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('name', __('Office Name'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('name') ? ' has-error' : '' }}">
                            {{ Form::text('name', '', ['class' => 'form-control', 'placeholder' => __('Name') ]) }}

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('code', __('Office Code'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6 {{ $errors->has('code') ? ' has-error' : '' }}">
                            {{ Form::text('code', '', ['class' => 'form-control', 'placeholder' => __('Office Code') ]) }}

                            @if ($errors->has('code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('code') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('parent', __('Home Office'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-6">
                            {{ Form::select('parent', [], null, ['class' => 'form-control select2 parent', 'placeholder' => __('Choose')]) }}
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary col-md-offset-3">
                        <i class="fa fa-floppy-o"></i> {{ __('Save') }}
                    </button>
                    <a href="{{ route('office.index') }}" class="btn btn-default">
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
    var data;
    $(function(){
        $('.corporate_id').select2({ 
            width: '100%', 
            allowClear: true, 
            placeholder: '{{ __('Choose') }}'}).on('change', function(){
                
                $('.parent').html('<option></option>');
                $.ajax({
                    url: '{{ route('office.corporate') }}',
                    data: {
                        q : $(this).val(),
                        selected: '{{ old('parent')}}',
                        except: ''
                    },
                    dataType: "json",
                }).done(function(response){
                    console.log(response);
                    
                    $('.parent').select2({
                        data: response,
                        width: '100%',
                        allowClear: true, 
                        placeholder: '{{ __('Choose') }}'
                    }).trigger('change');

                });

                console.log($(this).val());

                

            }).trigger('change');
    });
</script>
@endpush

