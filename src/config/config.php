<?php

/**
 * This file is part of the KraftHaus BauhausUser package.
 *
 * (c) KraftHaus <hello@krafthaus.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

	/**
	 * The menu structure of the package.
	 * @var array
	 */
	'menu' => [
		'title' => trans('bauhaususer::admin.menu'),
		'children' => [
			[
				'title' => trans('bauhaususer::admin.users.menu'),
				'class' => 'KraftHaus.BauhausUser.User'
			], [
				'title' => trans('bauhaususer::admin.groups.menu'),
				'class' => 'KraftHaus.BauhausUser.Group'
			], [
				'title' => trans('bauhaususer::admin.permissions.menu'),
				'class' => 'KraftHaus.BauhausUser.Permission'
			]
		]
	],

	/**
	 * Holds the model namespaces.
	 * @var array
	 */
	'model' => 'KraftHaus\BauhausUser\Page'

];
