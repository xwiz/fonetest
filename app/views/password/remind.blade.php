@extends('layouts.master')
@section('title', 'FoneNotes >> Forgot Password')
@section('content')
@if (Session::has('error'))
  {{ trans(Session::get('reason')) }}
@elseif (Session::has('success'))
  An email with the password reset has been sent.
@endif
<div class="panel">
 <h1>Password Reminder</h1>
 <hr />
 <h5>Enter your email below to receive your password reset link</h5>
 <br />
{{ Form::open(array('route' => 'password.request', 'class' =>'span5', 'style'=>'float:left')) }}
    <div class="input-group margin-bottom-sm">
    <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
    <input type="text" class="input-block-level" placeholder="Email address" name="email" id="email"/>
    </div>
    <button class="btn btn-primary" style="width: 100%;" type="submit">Reset Password</button>
{{ Form::close() }}
</div>
@stop