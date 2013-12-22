@extends('layouts.master')
@section('title', 'User >> Update Profile')
@section('content')
<div class="container">
            <div class="row">
                <div class="span6">
                    <div class="clear-form">                        
                        {{ Form::open(array('url'=>'user/update', 'class'=>'form-signup', 'style' => 'margin-left: 0px')) }}
                        <h3 class="form-signup-heading">Update your profile</h3>
                        <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                        <input type="hidden" value="{{$user->id}}" name="id"/>
                        {{ Form::text('firstname', $user->firstname, array('class'=>'input-block-level', 'placeholder'=>'First Name')) }}
                        {{ Form::text('lastname', $user->lastname, array('class'=>'input-block-level', 'placeholder'=>'Last Name')) }}
                        {{ Form::text('email', $user->email, array('class'=>'input-block-level', 'placeholder'=>'Email Address')) }}
                        {{ Form::password('password', array('class'=>'input-block-level', 'placeholder'=>'Password')) }}
                        {{ Form::password('password_confirmation', array('class'=>'input-block-level', 'placeholder'=>'Confirm Password')) }}
                        {{ Form::submit('Update Profile', array('class'=>'btn btn-large btn-primary btn-block'))}}
                        {{ Form::close() }}

                    </div>
                </div>
            </div>
        </div>
@stop