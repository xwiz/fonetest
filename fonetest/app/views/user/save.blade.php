@extends('layouts.master')
@section('title', 'User >> Save')
@section('content')
@include('includes.messages')
<style>
.placenter{
    padding-left: calc(50% - 98px);
    padding-left: -webkit-calc(50% - 98px);
    padding-left: -o-calc(50% - 98px);
    padding-left: -moz-calc(50% - 98px);
}
</style>

@if(isset($google))
<?php
$firstname = $google['given_name'];
$lastname = $google['family_name'];
$email = $google['email'];
?>
@endif

@if(isset($facebook))
<?php
$firstname = $facebook['first_name'];
$lastname = $facebook['last_name'];
$email = $facebook['email'];
?>
@endif


<div class="span6" style="margin: 20px auto; float: none;">
<div class="panel well" style="padding-bottom: 40px;">
<h3>Welcome {{ $firstname . '.' }}.</h3>
<h5> Please enter a new password to complete your signup</h5>
<hr />
{{ Form::open(array('route' => 'user.save', 'name' => 'saveuser')) }}
<input type="hidden" name="firstname" value="{{ $firstname }}" />
<input type="hidden" name="lastname" value="{{ $lastname }}" />
<input type="hidden" name="email" value="{{ $email }}" />
<label for="password">Enter Password</label>
<input type="password" class="form-control" name="password" />
<label for="password1">Enter Password Again</label>
<input type="password" class="form-control" name="password1" />
<button type="submit" class="btn btn-primary btn-xs placenter" style="float: right; margin-top:12px"><i class="icon-white fa-save fa-fw"></i>Save Profile</button>
{{ Form::close() }}
</div>
</div>
@stop