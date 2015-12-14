<?php

use Artdarek\OAuth\Facade\OAuth;

class AuthController extends \BaseController {

	public function index()
	{
		return View::make('auth.login');
	}

	public function create()
	{
		return View::make('auth.register');
	}

	public function store()
	{
		$validation = Validator::make(Input::all(), [
			'name' => 'min:2|max:40',
			'email' => 'required|email|unique:users',
			'password' => 'required|confirmed'
		]);

		if($validation->fails()) {
			return Redirect::to('auth/register')
						->withInput()
						->withErrors($validation);
		}

		$user = new User;
		$user->name = ucwords(Input::get('name'));
		$user->email = Input::get('email');
		$user->password = Hash::make(Input::get('password'));

		$user->save();

		Auth::login($user);

		return Redirect::to('contacts');
	}

	public function login()
	{
		$validation = Validator::make(Input::all(), [
			'email' => 'required|email',
			'password' => 'required'
		]);

		if($validation->fails()) {
			return Redirect::to('auth/login')
			               ->withInput()
			               ->withErrors($validation);
		}

		$auth = Auth::attempt([
			'email' => Input::get('email'),
			'password' => Input::get('password')
		]);

		if($auth) {
			return Redirect::to('contacts');
		} else {
			return Redirect::back()->withErrors(["Couldn't log in with the provided Email/Password combination"]);
		}
	}

	public function facebook()
	{

		$code = Input::get('code');

		$fb = OAuth::consumer('Facebook');

		if( ! empty($code)) {

			$token = $fb->requestAccessToken($code);
			$result = json_decode($fb->request('/me?fields=email'));

			$fb_id = $result->id;
			$email = $result->email;

			$user = User::where('email', '=', $email)->get()->first();

			if(count($user) > 0) {
				Auth::login($user);

				return Redirect::to('contacts');
			} else {
				$user = new User;
				$user->email = $email;
				$user->fb_id = $fb_id;
				$user->save();

				Auth::login($user);

				return Redirect::to('contacts');
			}

		} else {
			$url = $fb->getAuthorizationUri();

			return Redirect::to((String) $url);
		}

	}

	public function github()
	{

		$code = Input::get('code');

		OAuth::setHttpClient('CurlClient');

		$github = OAuth::consumer('GitHub');

		if( ! empty($code)) {

			$github->requestAccessToken($code);

			$result = json_decode($github->request('user/emails'));
			$email = $result[0];

			$user = User::where('email', '=', $email)->get()->first();

			if(count($user) > 0) {
				Auth::login($user);

				return Redirect::to('/contacts');
			} else {
				$user = new User;
				$user->email = $email;
				$user->save();

				Auth::login($user);

				return Redirect::to('/contacts');
			}

		} else {
			$url = $github->getAuthorizationUri();

			return Redirect::to((String) $url);
		}

	}

	public function logout()
	{
		Auth::logout();

		return Redirect::to('auth/login');
	}

}
