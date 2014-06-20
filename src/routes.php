<?php

/**
 * This file is part of the KraftHaus BauhausUser package.
 *
 * (c) KraftHaus <hello@krafthaus.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Route::group(['prefix' => Config::get('bauhaus::admin.uri')], function () {

	Route::get('sign-in', [
		'as'   => 'admin.sessions.create',
		'uses' => 'KraftHaus\BauhausUser\SessionsController@create'
	]);

	Route::post('sign-in', [
		'as'   => 'admin.sessions.store',
		'uses' => 'KraftHaus\BauhausUser\SessionsController@store'
	]);

	Route::get('sign-out', [
		'as'   => 'admin.sessions.sign-out',
		'uses' => 'KraftHaus\BauhausUser\SessionsController@destroy'
	]);

});