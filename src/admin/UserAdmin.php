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

use Illuminate\Support\Facades\Hash;
use KraftHaus\Bauhaus\Admin;

/**
 * Class UserAdmin
 * @package KraftHaus\BauhausUser
 */
class UserAdmin extends Admin
{

	/**
	 * Override the singular name.
	 * @var string
	 */
	protected $singularName = 'user';

	/**
	 * Override the plural name.
	 * @var string
	 */
	protected $pluralName = 'users';

	/**
	 * Configure the UserAdmin list.
	 *
	 * @param \KraftHaus\Bauhaus\Mapper\ListMapper $mapper
	 *
	 * @access public
	 * @return void
	 */
	public function configureList($mapper)
	{
		$mapper->identifier('full_name')->label('Name');
		$mapper->string('email');
	}

	/**
	 * Configure the UserAdmin form.
	 *
	 * @param  \KraftHaus\Bauhaus\Mapper\FormMapper $mapper
	 *
	 * @access public
	 * @return void
	 */
	public function configureForm($mapper)
	{
		$mapper->tab('General', function ($mapper) {
			$mapper->text('email');
			$mapper->password('password');
			$mapper->password('password_confirmation')->label('Confirm Password');
		});

		$mapper->tab('Info', function ($mapper) {
			$mapper->text('first_name')->label('First name');
			$mapper->text('last_name')->label('Last name');
			$mapper->belongsToMany('groups')->display('name');
		});
	}

	/**
	 * Configure the UserAdmin filters.
	 * @param  \KraftHaus\Bauhaus\Mapper\FilterMapper $mapper
	 *
	 * @access public
	 * @return void
	 */
	public function configureFilters($mapper)
	{
		$mapper->text('email')->label('Email');
	}

	/**
	 * Scoping on active state.
	 *
	 * @param  \KraftHaus\Bauhaus\Mapper\ScopeMapper $mapper
	 *
	 * @access public
	 * @return void
	 */
	public function configureScopes($mapper)
	{
		$mapper->scope('active')->label('Active members');
	}

	/**
	 * Create hook.
	 *
	 * @param  array $input
	 *
	 * @access public
	 * @return void
	 */
	public function create($input)
	{
		if ($input['password'] == '') {
			unset($input['password']);
		} else {
			$input['password'] = Hash::make($input['password']);
		}

		User::create($input);
	}

	/**
	 * Update hook.
	 *
	 * @param  array $input
	 *
	 * @access public
	 * @return void
	 */
	public function update($input)
	{
		$user = User::find($input['user_id']);

		if ($input['password'] == '') {
			unset($input['password']);
		} else {
			$input['password'] = Hash::make($input['password']);
		}

		$user->update($input);
	}

}