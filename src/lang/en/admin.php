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

	'menu' => 'Users',

	'users' => [
		'menu'  => 'Overview',
		'title' => [
			'singular' => 'User',
			'plural'   => 'Users'
		],
		'list' => [
			'name'   => 'Name',
			'email'  => 'Email address',
			'groups' => 'Groups'
		],
		'form' => [
			'email'            => 'Email address',
			'password'         => 'Password',
			'password-confirm' => 'Confirm Password',
			'first-name'       => 'First name',
			'last-name'        => 'Last name',
			'groups'           => 'Groups'
		],
		'filter' => [
			'email' => 'Email'
		],
		'scope' => [
			'active-users' => 'Active users'
		]
	],

	'groups' => [
		'menu'  => 'Groups',
		'title' => [
			'singular' => 'Group',
			'plural'   => 'Groups'
		],
		'list' => [
			'name'        => 'Name',
			'permissions' => 'Permissions'
		],
		'form' => [
			'name'        => 'Name',
			'permissions' => 'Permissions'
		]
	],

	'permissions' => [
		'menu'  => 'Permissions',
		'title' => [
			'singular' => 'Permission',
			'plural'   => 'Permissions'
		],
		'list' => [
			'name'        => 'Name',
			'value'       => 'Value',
			'description' => 'Description'
		],
		'form' => [
			'name' => [
				'label'       => 'Name',
				'placeholder' => 'The permission name'
			],
			'value' => [
				'label'       => 'Value',
				'placeholder' => 'The permission value'
			],
			'description' => [
				'label'       => 'Description',
				'placeholder' => 'The permission description'
			]
		],
		'filter' => [
			'name'        => 'Name',
			'value'       => 'Value',
			'description' => 'Description'
		]
	]

];