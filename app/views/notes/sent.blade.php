@extends('layouts.master')
@section('title', 'Notes >> Sent')
@section('content')

@include('includes.messages')
<h1>Sent Notes</h1>
<hr />
<div class="panel well span5">
<h3>Send Quick Note</h3>
<hr />
<form id="noteform" action="{{ url('notes/quick') }}">
    <div id="contact-div">
    <?php
    
    if(isset($data))
    {
        $contacts = $data['contacts'];
        $notes = $data['notes'];
        $calls = $data['calls'];
    }
    
    ?>
    Select a contact:
    <select class="contact-list" class="form-control" id="contact" name="contact">
    @if(isset($contacts))
    @foreach($contacts as $record)
    <option value="{{ $record->contact_number }}">{{ $record->contact_name }}</option>
    @endforeach
    @endif        
    </select>
    </div>
    <div id="writevoice">
    <h5>Enter a voice note</h5>
    <textarea id="voice-text" name="voice-text" rows="6" cols="38" class="note-text"></textarea>
    <input type="submit" id="sendnote" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Send Note"/>
    </div>
</form>
</div>
<div class="span6 table-responsive">
@if(isset($notes))
@if(count($notes) < 1)
<p>You have not sent any fonenote yet. Click {{ HTML::link('/notes/create', 'here') }} to send your first fonenote</p>
@else
@if(count($notes) > 15)
<p>Viewing 15 of {{ count($notes) }} notes</p>
@else
<p>Viewing {{ count($notes) }} of  {{ count($notes) }} notes</p>
@endif
@endif
@endif
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Number</th>
                <th>Content</th>
                <th>Picked</th>
                <th>Duration</th>
                <th>Date</th>
			</tr>
		</thead>
        <?php
        function getCall($calls, $id)
        {
            foreach($calls as $call)
            {
                if($call['id'] == $id)
                {
                    return $call;
                }
            }
            return false;
        }
        ?>
		<tbody>
            @if(isset($notes))
            <?php $count = 0; ?>
			@foreach($notes as $record)
            <?php $count++;
            $calldetail = getCall($calls, $record->resource_id);
            ?>
			<tr>
            <td>{{ $count }}</td>
            <td>{{ $record->contact_name }}</td>
            <td>{{ $record->contact_number }}</td>
            <td>{{ $record->content }}</td>
            @if(isset($calldetail['picked']))
            <td>{{ $calldetail['picked'] ? 'Yes' : 'No' }}</td>
            @else
            <td>No</td>
            @endif
            @if(isset($calldetail['duration']))
            <td>{{ $calldetail['duration'] }}</td>
            @else
            <td>0</td>
            @endif
            <td>{{ $calldetail['date'] }}</td>
			</tr>
			@endforeach
            @endif
		</tbody>
	</table>
    <?php echo $notes->links(); ?>
</div>

@stop