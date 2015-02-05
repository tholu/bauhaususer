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
 * Class Group
 * @package KraftHaus\BauhausUser
 */
class Group extends Model
{

	/**
	 * The validation rules.
	 * @var array
	 */
	public static $rules = [
		'name' => ['required']
	];

	/**
	 * The mass assignment protection array.
	 * @var array
	 */
	protected $fillable = [
		'name'
	];

	/**
	 * Permission relation.
	 *
	 * @access public
	 * @return mixed
	 */
	public function permissions()
	{
		return $this->belongsToMany('KraftHaus\BauhausUser\Permission');
	}

}
