@extends('admin_template')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            {{ Form::open(['route' => 'post.store', 'class' => 'form-horizontal']) }}
            <div class="box box-primary">
                <div class="box-body">

                    <div class="form-group">
                        {{ Form::label('title', __('Post Name'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-9 {{ $errors->has('title') ? ' has-error' : '' }}">
                            <p class="form-control-static">{{ $post->title }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('content', __('Content'), ['class' => 'control-label col-sm-3'] ) }}
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $post->content }}</p>
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{ route('post.index') }}" class="btn btn-default col-md-offset-3">
                        <i class="fa fa-long-arrow-left"></i> {{ __('Back') }}
                    </a>
                    <a href="{{ route('post.edit',['id' => $post->id]) }}" class="btn btn-success">
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

