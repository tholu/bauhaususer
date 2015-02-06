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

use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 * @package KraftHaus\BauhausUser
 */
class PermissionRegister extends Model
{

	protected $table = 'permissions_register';

	/**
	 * The validation rules.
	 * @var array
	 */
	public static $rules = [
		'name'  => ['required']
	];

	/**
	 * The mass assignment protection array.
	 * @var array
	 */
	protected $fillable = [
		'name'
	];

}
