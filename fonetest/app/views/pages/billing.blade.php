@extends('layouts.master')
@section('title', 'FoneNotes >> Billing')
@section('content')

@include('includes.messages')
<h1>Billing Details</h1>
<hr />
<div class="span6 table-responsive">
@if(isset($bills))
@if($total < 1)
<p>You have not sent any note yet.</p>
@else
@if($total > 10)
<p>Page {{ $bills->getCurrentPage() }} >> Viewing {{ $bills->count() }} of {{ $total }} records</p>
@else
<p>Page {{ $bills->getCurrentPage() }} >> Viewing {{ $bills->count() }} of {{ $total }} records</p>
@endif
@endif
@endif
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Number Called</th>
				<th>Cost</th>
                <th>Date</th>
			</tr>
		</thead>
		<tbody>
            @if(isset($bills))
            <?php $count = 0; ?>
			@foreach($bills as $record)
            <?php $count++; ?>
			<tr>
            <td>{{ $count }}</td>
            <td>{{ $record['object'] }}</td>
            <td>{{ $record['amount'] }}</td>
            <td>{{ $record['date'] }}</td>
			</tr>
			@endforeach
            @endif
		</tbody>
	</table>
{{ $bills->links() }}
</div>

@stop