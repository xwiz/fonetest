@extends('layouts.master')
@section('title', 'Contacts >> Manage')
@section('content')

@include('includes.messages')
<h1>Manage Contacts</h1>
<hr />
<div class="panel well span5">
<h3>Save new contact.</h3>
<hr />
{{ Form::open(array('route' => 'contacts.save', 'id' => 'uploadContact', 'name' => 'uploadContact')) }}
<label for="name">Enter Name</label>
<input type="text" class="form-control" name="name" id="name" placeholder="Full Name" />
<label for="name">Number</label>
<input type="text" class="form-control" name="name" id="name" placeholder="Mobile Number"/>
<button type="submit" class="btn btn-primary btn-xs" style="float: right; margin-top:9px"><i class="icon-white fa-save fa-fw"></i>Save Contact</button>
{{ Form::close() }}
</div>
<div class="span6 table-responsive">
@if(isset($contacts))
@if(count($contacts) < 1)
<p>You have not saved any contacts yet.</p>
@else
@if(count($contacts) > 10)
<p>Page {{ $contacts->getCurrentPage() }} >> Viewing {{ $contacts->count() }} of {{ $total }} contacts</p>
@else
<p>Page {{ $contacts->getCurrentPage() }} >> Viewing {{ $contacts->count() }} of {{ $total }} contacts</p>
@endif
@endif
@endif
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Number</th>
			</tr>
		</thead>
		<tbody>
            @if(isset($contacts))
            <?php $count = 0; ?>
			@foreach($contacts as $contact)
            <?php $count++; ?>
			<tr>
            <td>{{ $count }}</td>
            <td>{{ $contact->contact_name }}</td>
            <td>{{ $contact->contact_number }}</td>
			</tr>
			@endforeach
            @endif
		</tbody>
	</table>
    <?php echo $contacts->links(); ?>
</div>

@stop