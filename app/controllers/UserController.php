<?php

class UserController extends BaseController {
    
    /**
     * Default constructor with authentication and csrf filters 
     */
    public function __construct() {
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('auth', array('only'=>array('dashboard', 'profile')));
    }
    
    /**
     * Self descriptive
     */
    public function resetPassword()
    {
        $credentials = array('email' => Input::get('email'));
        return Password::remind($credentials);
    }
    
    /**
     * Saves a user who has signed up from Facebook or Google
     * @return Response 
     */
    public function save()
    {
        $pwd = Input::get('password');
        $pwd1 = Input::get('password1');
        if($pwd != $pwd1)
        {
            return Redirect::to('user/register')
            ->with('error', "The two passwords don't match.")
            ->withInput();
        }
        //no errors? sign up the dude
        $user = new User();
        $user->firstname = Input::get('firstname');
        $user->lastname = Input::get('lastname');
        $user->email = Input::get('email');
        $user->password = Hash::make($pwd);
        $user->save();
        Auth::login($user);
        //all done
        return Redirect::to('user/welcome')->with('message', "Thanks for signing up, Let's get started!");
    }
    
    public function remindPassword()
    {
        return View::make('user.remindpassword');
    }

	/**
	 * Log in a user
	 *
	 * @return Response
	 */
	public function login()
	{
        $email = Input::get('email');
        $pwd = Input::get('password');
        $remember = Input::get('remember');
        if(!($pwd && $email))
        {
            return Redirect::to('/')
            ->with('message', 'Please enter your username and password and try to login again.')
            ->withInput();
        }
        if (Auth::attempt(array('email'=>$email, 'password'=>$pwd), $remember)) {
	       return Redirect::intended('user/dashboard')->with('message', 'You are now logged in!');
        }
        else {
            return Redirect::to('/')
            ->with('error', 'Your username/password combination was incorrect')
            ->withInput();
        }
	}
    
    /**
     * Log out current user
     * 
     * @return Response
     */
    public function logout() {
        Auth::logout();
        return Redirect::to('/')->with('message', 'You have been logged out successfully!');
    }
    
    /**
     * Display the user dashboard
     * 
     * @return Response
     */
    public function dashboard(){
        return View::make('user.dashboard');
    }

	/**
	 * Show the form for user registraiton.
	 *
	 * @return Response
	 */
	public function register()
	{
	   return View::make('user.register');
	}

	/**
	 * Create a new user
	 *
	 * @return Response
	 */
	public function create()
	{
		$validator = Validator::make(Input::all(), User::$rules);
        if ($validator->passes()){
            $user = new User;
            $user->firstname = Input::get('firstname');
            $user->lastname = Input::get('lastname');
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $user->save();
            return Redirect::to('user/welcome')->with('message', "Thanks for signing up, Let's get started!");
        }
        else{
            return Redirect::to('user/register')
            ->with('message', 'The following errors occurred')
            ->withErrors($validator)
            ->withInput();
        }
	}
    
    /**
     * Disply a simple form to manage user profile
     * @return Response
     */
    public function profile()
    {
        $user = Auth::user();
        return View::make('user.profile')->with('user', $user);
    }
    
    /**
     * Yea, update user profile
     */
    public function updateProfile()
    {
        $id = Input::get('id');
        $user = User::find($id);
        $user->update(Input::except('password'));
    }
    
    /**
     * Login user with facebook
     *
     * @return void
     */

    public function loginWithFacebook()
    {
        // get data from input
        $code = Input::get('code');

        // get fb service
        $fb = OAuth::consumer('Facebook');

        // check if code is valid

        // if code is provided get user data and sign in
        if (!empty($code)) {

            // This was a callback request from google, get the token
            $token = $fb->requestAccessToken($code);

            // Send a request with it
            $result = json_decode($fb->request('/me'), true);
            $user = User::where('email', '=', $result['email'])->first();
            if($user)
            {
                Auth::login($user);
                return Redirect::intended('user/dashboard')->with('message', 'You are now logged in!');
            }
            else{
                return View::make('user/save')->with('facebook', $result);
            }
        }
        // if not ask for permission first
        else {
            // get fb authorization
            $url = $fb->getAuthorizationUri();

            // return to facebook login url
            return View::make('user.login')->with('authUrl', $url);
        }
    }

    /**
     * Login user with Google Oauth2.0
     *
     * @return void
     */

    public function loginWithGoogle()
    {
        // get data from input
        $code = Input::get('code');

        // get google service
        $googleService = OAuth::consumer('Google');

        // check if code is valid

        // if code is provided get user data and sign in
        if (!empty($code)) {

            // This was a callback request from google, get the token
            $token = $googleService->requestAccessToken($code);

            // Send a request with it
            $result = json_decode($googleService->request('https://www.googleapis.com/oauth2/v1/userinfo'), true);
            $user = User::where('email', '=', $result['email'])->first();
            if($user)
            {
                Auth::login($user);
                return Redirect::intended('user/dashboard')->with('message', 'You are now logged in!');
            }
            else{
                return View::make('user/save')->with('google', $result);
            }
        }
        // if not ask for permission first
        else {
            // get googleService authorization
            $url = $googleService->getAuthorizationUri();

            // return to facebook login url
            return View::make('user.login')->with('authUrl', $url);
        }
    }

}
