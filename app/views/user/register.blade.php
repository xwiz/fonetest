@extends('layouts.master')
@section('title', 'User >> Register')
@section('content')
<div class="container">
            <div class="row">
                <div class="span6">
                    <h1>Welcome to Fonenote!</h1>
                    <hr/>
                    {{ HTML::image('/img/fonenotehead.png', 'fonenote splash', array('style' => 'width:100%')) }}
                    <p class="welcome-text">Experience the web in a new way. With Fonenotes, you can leave voice messages for your loved ones from anywhere and we'll send it right to their phones. Calling has never been much easier and flexible.
                    </p>
                </div>
                <div class="offset1 span5">
                    <div class="clear-form">                        
                        {{ Form::open(array('url'=>'user/create', 'class'=>'form-signup')) }}
                        <h3 class="form-signup-heading">Signup to create Fonenotes</h3>
                        <h5>This will take less than a minute</h5>
                        <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                        {{ Form::text('firstname', null, array('class'=>'input-block-level', 'placeholder'=>'First Name')) }}
                        {{ Form::text('lastname', null, array('class'=>'input-block-level', 'placeholder'=>'Last Name')) }}
                        {{ Form::text('email', null, array('class'=>'input-block-level', 'placeholder'=>'Email Address')) }}
                        {{ Form::password('password', array('class'=>'input-block-level', 'placeholder'=>'Password')) }}
                        {{ Form::password('password_confirmation', array('class'=>'input-block-level', 'placeholder'=>'Confirm Password')) }}
                        {{ Form::submit('Register', array('class'=>'btn btn-large btn-primary btn-block'))}}
                        {{ Form::close() }}

                    </div>
                </div>
            </div>
        </div>
@stop