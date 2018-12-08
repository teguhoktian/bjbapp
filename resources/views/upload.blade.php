{{ Form::open(['url' => 'upload', 'files' => 'true']) }}

{{ Form::file('ybt') }}

{{ Form::submit('Submit') }}

{{ Form::close() }}