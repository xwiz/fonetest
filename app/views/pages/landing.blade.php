@extends('layouts.master')
@section('title', 'FoneNotes')
@section('content')
<div class="container">
            <div class="row">
                <div class="span6">
                    <h1>Welcome to Fonenotes!</h1>
                    <hr/>
                    @include('includes.messages')
                    {{ HTML::image('/img/fonenotehead.png', 'fonenote splash', array('style' => 'width:100%')) }}
                    <p class="welcome-text">Experience the web in a new way. With Fonenotes, you can leave voice messages for your loved ones from anywhere and we'll send it right to their phones. Calling has never been much easier and flexible.
                    </p>
                </div>
                <div class="offset1 span5">
                    <div class="clear-form">                        
                        {{ Form::open(array('url'=>'user/login')) }}               
                            <div class="form-heading">
                                <h3>Sign In</h3>                               
                            </div>  
                            <div class="form-body">
                                <div class="input-group margin-bottom-sm">
                                <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                                <input type="text" class="input-block-level" placeholder="Email address" name="email" id="email"/>
                                </div>
                                <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                                <input type="password" class="input-block-level" placeholder="Password" name="password" id="password"/>
                                </div>
                                <label class="checkbox">
                                    <input type="checkbox" value="remember-me" id="remember" name="remember"/> Remember me
                                </label>
                                <div>
                                <button class="btn btn-primary" style="width: 100%;" type="submit">Login</button>
                                </div>
                            </div>                                 
                            <div class="form-footer"> 
                                <hr />
                                <p class="center">
                                    <a href="{{ url('password/reset') }}">Forgot your password?</a>
                                </p>
                      
                                <hr/>
                                <div class="other-login">
                                <h4>Or Sign in with other accounts</h4>
                                <br />                                
                                <a href="{{ $data['facebook'] }}" class="btn btn-primary btn-other" type="submit"><i class="icon-white fa-facebook fa-fw"></i>Sign in with Facebook</a>
                                <a href="{{ $data['google'] }}" class="btn btn-danger btn-other" type="submit"><i class="icon-white fa-google-plus fa-fw"></i>Sign in with Google</a>
                                </div>
                            </div>                            
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
@stop