
{!! Form::open([
    'id' => 'delete-form',
    'method' => 'PUT',
    'onsubmit' => 'return confirm(\'Do you really want to submit the form?\');',
    'route' => ['approval.bookingKreditDataAction', $id],'style'=>'display:inline']) 
!!}
{!! Form::hidden('action', 'Approval') !!}
@if($first_approval_status == 'Approval')
{!!  Form::hidden('aproval', 'Second Approval') !!} 
@else
{!! Form::hidden('aproval', 'First Approval') !!}
@endif
<button class="btn btn-success btn-sm"><span class="fa fa-check" aria-hidden="true"></span></button>
{!! Form::close() !!}

{!! Form::open([
    'id' => 'delete-form',
    'method' => 'PUT',
    'onsubmit' => 'return confirm(\'Do you really want to submit the form?\');',
    'route' => ['approval.bookingKreditDataAction', $id],'style'=>'display:inline']) 
!!}
@if($first_approval_status == 'Approval')
{!!  Form::hidden('aproval', 'Second Approval') !!} 
@else
{!! Form::hidden('aproval', 'First Approval') !!}
@endif
{!! Form::hidden('action', 'Rejected') !!}
<button class="btn btn-danger btn-sm"><span class="fa fa-times" aria-hidden="true"></span></button>
{!! Form::close() !!}



