@extends('admin_template')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            {{ Form::model($post, ['route' => ['post.update', $post->id], 'class' => 'form-horizontal', 'method' => 'PATCH']) }}
            <div class="box box-primary">
                <div class="box-body">

                    <div class="form-group">
                        {{ Form::label('title', __('Post Title'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-9 {{ $errors->has('title') ? ' has-error' : '' }}">
                            {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('Post Title') ]) }}

                            @if ($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('content', __('Content'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-9 {{ $errors->has('content') ? ' has-error' : '' }}">
                            {{ Form::textarea('content', null, ['class' => 'form-control summernote' ]) }}

                            @if ($errors->has('content'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('content') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary col-md-offset-3">
                        <i class="fa fa-floppy-o"></i> {{ __('Save') }}
                    </button>
                    <a href="{{ route('post.index') }}" class="btn btn-default">
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
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
@endpush

@push('script')
<script type="text/javascript" src="{{ asset('admin-lte/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script type="text/javascript">
    var data;
    $(function(){
        $('.permission').select2({ 
            width: '100%', 
            allowClear: true, 
            placeholder: '{{ __('Choose') }}'}).trigger('change');
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: '300'
        });
    });
</script>
@endpush

