<?php

/**
 * This file is part of the KraftHaus BauhausUser package.
 *
 * (c) KraftHaus <hello@krafthaus.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Route::get(Config::get('bauhaus::admin.auth.login_path'), [
	'as'   => 'admin.sessions.create',
	'uses' => 'KraftHaus\BauhausUser\SessionsController@create'
]);

Route::post(Config::get('bauhaus::admin.auth.login_path'), [
	'as'   => 'admin.sessions.store',
	'uses' => 'KraftHaus\BauhausUser\SessionsController@store'
]);

Route::get(Config::get('bauhaus::admin.auth.logout_path'), [
	'as'   => 'admin.sessions.sign-out',
	'uses' => 'KraftHaus\BauhausUser\SessionsController@destroy'
]);