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

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package KraftHaus\BauhausUser
 */
class User extends Model implements UserInterface, RemindableInterface
{

	use UserTrait,
		RemindableTrait;

	/**
	 * The validation rules.
	 * @var array
	 */
	public static $rules = [
		'email'      => ['required', 'email'],
		'password_confirmation' => ['required_with:password'],
		'first_name' => ['required'],
		'last_name'  => ['required']
	];

	/**
	 * The mass assignment protection array.
	 * @var array
	 */
	protected $fillable = [
		'email',
		'password',
		'first_name',
		'last_name',
		'is_active'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token'
	];

	/**
	 * The full_name accessor.
	 * Creates a full name from the first and last name attribute.
	 *
	 * @access public
	 * @return string
	 */
	public function getFullNameAttribute()
	{
		return sprintf('%s %s', $this->first_name, $this->last_name);
	}

	/**
	 * Groups relation.
	 *
	 * @access public
	 * @return mixed
	 */
	public function groups()
	{
		return $this->belongsToMany('KraftHaus\BauhausUser\Group','users_groups');
	}

	/**
	 * Active scope.
	 *
	 * @param $query
	 *
	 * @access public
	 * @return mixed
	 */
	public function scopeActive($query)
	{
		return $query->where('activated', '1');
	}



	/**
	 * Check if a user has a given permission.
	 *
	 * @param  string $value
	 *
	 * @access public
	 * @return bool
	 */
	public function hasPermission($value)
	{
		foreach ($this->groups as $group) {
			foreach ($group->permissions as $permission) {
				if ($permission->value == $value) {
					return true;
				}
			}
		}

		return false;
	}

}
