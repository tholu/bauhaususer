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
		'title' => 'Users',
		'children' => [
			[
				'title' => 'Overview',
				'class' => 'KraftHaus\BauhausUser\User'
			], [
				'title' => 'Groups',
				'class' => 'KraftHaus\BauhausUser\Group'
			]
		]
	],

	/**
	 * Holds the model namespaces.
	 * @var array
	 */
	'model' => 'KraftHaus\BauhausUser\Page'

];