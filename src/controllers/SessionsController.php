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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

/**
 * Class SessionsController
 * @package KraftHaus\BauhausUser
 */
class SessionsController extends Controller
{

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('krafthaus/bauhaususer::sessions.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make(Input::all(), [
			'email'    => ['required', 'email'],
			'password' => ['required']
		]);

		if ($validator->fails()) {
			Session::flash('message.error', 'Validation error.');
			return Redirect::route('admin.sessions.create')
				->withInput()
				->withErrors($validator);
		}

		$input = [
			'email'     => Input::get('email'),
			'password'  => Input::get('password'),
			'is_active' => 1
		];

		if (Auth::attempt($input, Input::has('remember'))) {
			Session::flash('message.success', 'User logged in.');
			return Redirect::route('admin.dashboard');
		}

		Session::flash('message.error', 'User not found.');
		return Redirect::route('admin.sessions.create')
			->withInput();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy()
	{
		Auth::logout();
		return Redirect::route('admin.sessions.create');
	}

}