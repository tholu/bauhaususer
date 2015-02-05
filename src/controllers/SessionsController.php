<?php

namespace KraftHaus\BauhausUser;

/**
 * This file is part of the KraftHaus BauhausUser package.
 *
 * (c) KraftHaus <hello@krafthaus.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Cartalyst\Sentry\Users;
use Cartalyst\Sentry\Throttling;

/**
 * Class SessionsController
 * @package KraftHaus\BauhausUser
 */
class SessionsController extends Controller
{

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return View
	 */
	public function create()
	{
		return View::make('krafthaus/bauhaususer::sessions.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Redirect
	 */
	public function store()
	{
		$validator = Validator::make(Input::all(), [
			'email'    => ['required', 'email'],
			'password' => ['required']
		]);

		if ($validator->fails()) {
			Session::flash('message.error', trans('bauhaususer::messages.error.messages.sign-in.validation-error'));
			return Redirect::route('admin.sessions.create')
				->withInput()
				->withErrors($validator);
		}

		try {
			$user = \Sentry::findUserByLogin(Input::get('email'));

			\Sentry::login($user,Input::has('remember'));

			Session::flash('message.success', trans('bauhaususer::messages.success.messages.sign-in.user-signed-in'));
			return Redirect::route('admin.dashboard');
		}

		catch (Users\LoginRequiredException $e)
		{
			Session::flash('message.error', trans('bauhaususer::messages.error.messages.sign-in.login-required'));
		}
		catch (Users\UserNotFoundException $e)
		{
			Session::flash('message.error', trans('bauhaususer::messages.error.messages.sign-in.user-not-found'));
		}
		catch (Users\UserNotActivatedException $e)
		{
			Session::flash('message.error', trans('bauhaususer::messages.error.messages.sign-in.user-not-active'));
		}

		catch (Throttling\UserSuspendedException $e)
		{
			$throttle = \Sentry::findThrottlerByUserLogin(Input::get('email'));
			$time = $throttle->getSuspensionTime();

			$str = trans('bauhaususer::messages.error.messages.sign-in.user-suspended');

			Session::flash('message.error', str_replace('[%s]',$time,$str));
		}
		catch (Throttling\UserBannedException $e)
		{
			Session::flash('message.error', trans('bauhaususer::messages.error.messages.sign-in.user-banned'));
		}

		return Redirect::route('admin.sessions.create')
			->withInput();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Redirect
	 */
	public function destroy()
	{
		\Sentry::logout();

		Session::flash('message.success', trans('bauhaususer::messages.success.messages.sign-out.user-signed-out'));
		return Redirect::route('admin.sessions.create');
	}

}
