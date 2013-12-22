<?php

class PasswordController extends BaseController
{

    public function request()
    {
        $credentials = array('email' => Input::get('email'));
        Password::remind($credentials);
        return Redirect::to('/')->with('success', 'Your password reset information has been sent to your mail.');
    }

    public function reset($token)
    {
        return View::make('password.reset')->with('token', $token);
    }

    public function remind()
    {
        return View::make('password.remind');
    }

    public function update()
    {
        $credentials = array('email' => Input::get('email'));

        Password::reset($credentials, function ($user, $password)
        {
            $user->password = Hash::make($password);
            $user->save();  
        });
        return Redirect::to('/')->
                with('success', 'Your password has been reset successfully.');
    }
}

?>