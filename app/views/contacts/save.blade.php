@extends('layouts.master')
@section('title', 'Contacts >> Save')
@section('content')
<h1>Save New Contact</h1>
@if(isset($data['success']))

@endif
<p>Save the contact you just sent a fonenote to so you can easily send to them in the future.</p>
<div class="span6" style="margin: 20px auto; float: none;">
<div class="panel well " style="padding-bottom: 40px;">
{{ Form::open(array('route' => 'contacts.save', 'id' => 'uploadContact', 'name' => 'uploadContact')) }}
<label for="name">Enter Name</label>
<input type="text" class="form-control" name="name" id="name" placeholder="Full Name" />
<label for="name">Number</label>
<input type="hidden" class="form-control" name="number" id="number" value="{{ $data['number'] }}"/>
<input type="text" class="form-control" value="{{ $data['number'] }}" disabled />
<button type="submit" class="btn btn-primary btn-xs" style="float: right; margin-top:12px"><i class="icon-white fa-save fa-fw"></i>Save Contact</button>
{{ Form::close() }}
</div>
</div>
@stop