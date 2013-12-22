<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function landing()
	{
        if(Auth::check())
        {
            return View::make('user.dashboard');
        }
        $fb = OAuth::consumer('Facebook');
        $gg = OAuth::consumer('Google');
        $data['facebook'] = $fb->getAuthorizationUri(
            array('redirect_uri' => url('login/fb'))
        );
        $data['google'] = $gg->getAuthorizationUri(
            array('redirect_uri' => url('/login/google'))
        );
		return View::make('pages.landing')->with('data', $data);
	}

}