@can('view user')
<a href="{{ route('corporate.show', $id) }}" class="btn btn-sm btn-success">
    <span class="fa fa-eye" aria-hidden="true"></span>
</a>
@endcan

@can('update user')
<a href="{{ route('corporate.edit', $id) }}" class="btn btn-primary btn-sm">
    <span class="fa fa-edit" aria-hidden="true"></span>
</a>
@endcan

@can('delete user')
{!! Form::open([
    'id' => 'delete-form',
    'method' => 'DELETE',
    'onsubmit' => 'return confirm(\'Do you really want to submit the form?\');',
    'route' => ['corporate.destroy', $id],'style'=>'display:inline']) 
!!}
<button class="btn btn-danger btn-sm"><span class="fa fa-trash" aria-hidden="true"></span></button>
{!! Form::close() !!}
@endcan
