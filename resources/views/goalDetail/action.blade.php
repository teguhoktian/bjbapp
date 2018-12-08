<a href="{{ route('goalDetail.show', $id) }}" class="btn btn-sm btn-success">
    <span class="fa fa-eye" aria-hidden="true"></span>
</a>


<a href="{{ route('goalDetail.edit', $id) }}" class="btn btn-primary btn-sm">
    <span class="fa fa-edit" aria-hidden="true"></span>
</a>


{!! Form::open([
    'id' => 'delete-form-'.$id,
    'method' => 'DELETE',
    'onsubmit' => 'return confirm(\'Do you really want to submit the form?\');',
    'route' => ['goalDetail.destroy', $id],'style'=>'display:inline']) 
!!}
<button type="submit" class="btn btn-danger btn-sm"><span class="fa fa-trash" aria-hidden="true"></span></button>
{!! Form::close() !!}
